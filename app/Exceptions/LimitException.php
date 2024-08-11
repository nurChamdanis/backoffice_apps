<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

class LimitException extends TooManyRequestsHttpException
{
    public function __construct($message = '', Throwable $previous = null, array $headers = [], $code = 0)
    {
        parent::__construct(null, $message, $previous, $code, $headers);
    }
}
