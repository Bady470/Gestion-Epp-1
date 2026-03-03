FROM php:8.3-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev libzip-dev zip libpng-dev \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql zip gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copiar proyecto
COPY . .

# Instalar dependencias Laravel
RUN composer install --no-dev --optimize-autoloader

# Exponer puerto
EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000
