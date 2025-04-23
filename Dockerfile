FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    npm \
    nodejs \
    libzip-dev \
    libpq-dev \
    libcurl4-openssl-dev \
    libssl-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# ✅ Install Composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Node dependencies and build assets
RUN npm install && npm run build

# Clear cache and optimize
RUN php artisan optimize:clear
RUN php artisan config:cache && php artisan view:cache
RUN php artisan storage:link


# Set permissions
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Expose app port
EXPOSE 8000

# Start Laravel server
# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
CMD php artisan config:cache && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
