FROM php:8.0-fpm

# Копіюємо Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Встановлюємо необхідні розширення
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

WORKDIR /var/www/

# Встановлюємо права на файли і директорії
RUN chown -R www-data:www-data /var/www

# Запускаємо PHP-FPM
CMD ["php-fpm"]
