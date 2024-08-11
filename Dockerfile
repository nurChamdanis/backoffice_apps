FROM bitnami/laravel:10 as builder

COPY . .

RUN composer install

FROM webdevops/php-nginx:8.2-alpine

COPY --from=builder /app /app

ENV WEB_DOCUMENT_ROOT=/app/public

WORKDIR /app

RUN chmod -R ug+rwx bootstrap/cache storage \
    && chown -R application:application bootstrap/cache storage

# .env is required
RUN php artisan key:generate --force