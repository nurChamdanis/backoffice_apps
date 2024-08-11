<?php

namespace App\Http\Middleware;

use App\Exceptions\LimitException;
use Closure;
use Illuminate\Cache\RateLimiter;
use Illuminate\Cache\RateLimiting\Unlimited;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Arr;
use Illuminate\Support\InteractsWithTime;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class ThrottleRequests
{
    use InteractsWithTime;

    protected $limiter;
    protected static $shouldHashKeys = true;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    public static function using($name)
    {
        return static::class.':'.$name;
    }

    public static function with($maxAttempts = 60, $decayMinutes = 1, $prefix = '')
    {
        return static::class.':'.implode(',', func_get_args());
    }

    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = '')
    {
        if (is_string($maxAttempts)
            && func_num_args() === 3
            && ! is_null($limiter = $this->limiter->limiter($maxAttempts))) {
            return $this->handleRequestUsingNamedLimiter($request, $next, $maxAttempts, $limiter);
        }

        return $this->handleRequest(
            $request,
            $next,
            [
                (object) [
                    'key' => $prefix.$this->resolveRequestSignature($request),
                    'maxAttempts' => $this->resolveMaxAttempts($request, $maxAttempts),
                    'decayMinutes' => $decayMinutes,
                    'responseCallback' => null,
                ],
            ]
        );
    }

    protected function handleRequestUsingNamedLimiter($request, Closure $next, $limiterName, Closure $limiter)
    {
        $limiterResponse = $limiter($request);

        if ($limiterResponse instanceof Response) {
            return $limiterResponse;
        } elseif ($limiterResponse instanceof Unlimited) {
            return $next($request);
        }

        return $this->handleRequest(
            $request,
            $next,
            collect(Arr::wrap($limiterResponse))->map(function ($limit) use ($limiterName) {
                return (object) [
                    'key' => self::$shouldHashKeys ? md5($limiterName.$limit->key) : $limiterName.':'.$limit->key,
                    'maxAttempts' => $limit->maxAttempts,
                    'decayMinutes' => $limit->decayMinutes,
                    'responseCallback' => $limit->responseCallback,
                ];
            })->all()
        );
    }

    protected function handleRequest($request, Closure $next, array $limits)
    {
        foreach ($limits as $limit) {
            if ($this->limiter->tooManyAttempts($limit->key, $limit->maxAttempts)) {

                return $this->buildResponse($limit->key, $limit->maxAttempts, $limit);
            }

            $this->limiter->hit($limit->key, $limit->decayMinutes * 60);
        }

        $response = $next($request);

        foreach ($limits as $limit) {
            $response = $this->addHeaders(
                $response,
                $limit->maxAttempts,
                $this->calculateRemainingAttempts($limit->key, $limit->maxAttempts)
            );
        }

        return $response;
    }

    protected function resolveMaxAttempts($request, $maxAttempts)
    {
        if (str_contains($maxAttempts, '|')) {
            $maxAttempts = explode('|', $maxAttempts, 2)[$request->user() ? 1 : 0];
        }

        if (! is_numeric($maxAttempts) && $request->user()) {
            $maxAttempts = $request->user()->{$maxAttempts};
        }

        return (int) $maxAttempts;
    }

    protected function resolveRequestSignature($request)
    {
        if ($user = $request->user()) {
            return $this->formatIdentifier($user->getAuthIdentifier());
        } elseif ($route = $request->route()) {
            return $this->formatIdentifier($route->getDomain().'|'.$request->ip());
        }

        throw new RuntimeException('Unable to generate the request signature. Route unavailable.');
    }

    protected function buildResponse($key, $maxAttempts, $limit)
    {
        return response()->json([
            'error'     => true,
            'rc'        => '0032',
            'message'   => 'Akun Anda di blokir sementara, Silahkan coba kembali setelah '.$limit->decayMinutes.' menit',
            'data'      => null
        ], 422);
    }

    protected function buildException($request, $key, $maxAttempts, $responseCallback = null, $limit)
    {
        $retryAfter = $this->getTimeUntilNextRetry($key);

        $headers = $this->getHeaders(
            $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts, $retryAfter),
            $retryAfter
        );

        return is_callable($responseCallback)
                    ? new HttpResponseException($responseCallback($request, $headers))
                    : new LimitException('Too Many Attempts.', null, $headers);
    }

    protected function getTimeUntilNextRetry($key)
    {
        return $this->limiter->availableIn($key);
    }

    protected function addHeaders(Response $response, $maxAttempts, $remainingAttempts, $retryAfter = null)
    {
        $response->headers->add(
            $this->getHeaders($maxAttempts, $remainingAttempts, $retryAfter, $response)
        );

        return $response;
    }

    protected function getHeaders($maxAttempts,
                                  $remainingAttempts,
                                  $retryAfter = null,
                                  ?Response $response = null)
    {
        if ($response &&
            ! is_null($response->headers->get('X-RateLimit-Remaining')) &&
            (int) $response->headers->get('X-RateLimit-Remaining') <= (int) $remainingAttempts) {
            return [];
        }

        $headers = [
            'X-RateLimit-Limit' => $maxAttempts,
            'X-RateLimit-Remaining' => $remainingAttempts,
        ];

        if (! is_null($retryAfter)) {
            $headers['Retry-After'] = $retryAfter;
            $headers['X-RateLimit-Reset'] = $this->availableAt($retryAfter);
        }

        return $headers;
    }

    protected function calculateRemainingAttempts($key, $maxAttempts, $retryAfter = null)
    {
        return is_null($retryAfter) ? $this->limiter->retriesLeft($key, $maxAttempts) : 0;
    }

    private function formatIdentifier($value)
    {
        return self::$shouldHashKeys ? sha1($value) : $value;
    }

    public static function shouldHashKeys(bool $shouldHashKeys = true)
    {
        self::$shouldHashKeys = $shouldHashKeys;
    }
}
