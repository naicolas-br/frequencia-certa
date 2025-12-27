# === Build Frontend ===
FROM node:20-alpine as node_builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# === Backend + Laravel deps ===
FROM composer:2 as composer_builder
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-progress
COPY . .

# === Runtime ===
FROM php:8.3-cli-alpine
WORKDIR /var/www/html

RUN apk add --no-cache bash unzip libzip-dev icu-dev oniguruma-dev postgresql-dev \
 && docker-php-ext-install pdo_pgsql intl zip

COPY . .
COPY --from=composer_builder /app/vendor ./vendor
COPY --from=node_builder /app/public/build ./public/build

RUN chmod -R 775 storage bootstrap/cache || true

CMD sh -c "\
  php artisan migrate --force --no-interaction \
  && php artisan optimize \
  && php -S 0.0.0.0:${PORT:-8000} -t public \
"
