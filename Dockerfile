FROM php:8.4-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    caddy \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    icu-dev \
    oniguruma-dev \
    postgresql-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring zip bcmath gd intl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy application code
COPY . .

# Install Laravel dependencies (Production mode)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8080

# Copy the deploy script and give it execution permissions
COPY render/deploy.sh /usr/local/bin/deploy.sh
RUN chmod +x /usr/local/bin/deploy.sh

# Change your CMD to use the script
CMD ["/usr/local/bin/deploy.sh"]