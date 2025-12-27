#!/usr/bin/env bash
set -euo pipefail

echo "==> Frontend: instalando deps e buildando assets (Vite)"
npm ci
npm run build

echo "==> Backend: instalando deps (Laravel)"
composer install \
  --no-dev \
  --optimize-autoloader \
  --no-interaction \
  --prefer-dist \
  --no-progress

echo "==> Limpando caches antigos"
php artisan optimize:clear

echo "==> Gerando caches de performance"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Rodando migrations com conexão DIRECT (Neon)"
export DATABASE_URL="$DATABASE_URL_DIRECT"
php artisan migrate --force --no-interaction

echo "==> Build finalizado com sucesso"
