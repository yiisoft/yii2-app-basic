FROM php:8.2-fpm

# Install system packages
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy app code
COPY . .

# Install PHP dependencies
RUN composer install

CMD ["php-fpm"]

