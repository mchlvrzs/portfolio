# PHP 8.3 + Composer + Node (Vite) for Laravel on Render free tier
FROM php:8.3-cli-bookworm

# System libs + Postgres PDO (Render free DB is PostgreSQL)
RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        unzip \
        curl \
        libpq-dev \
        libzip-dev \
        libpng-dev \
        nodejs \
        npm \
    && docker-php-ext-install -j$(nproc) pdo_pgsql pgsql zip bcmath \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy app source (vendor / node_modules excluded via .dockerignore)
COPY . .

# Install PHP deps + build Vite assets into public/build
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist \
    && npm ci \
    && npm run build \
    && rm -rf node_modules \
    && chmod -R 775 storage bootstrap/cache

COPY docker/start.sh /usr/local/bin/start-laravel.sh
RUN chmod +x /usr/local/bin/start-laravel.sh

# Render sets $PORT; php artisan serve binds to it
EXPOSE 8000
CMD ["/usr/local/bin/start-laravel.sh"]
