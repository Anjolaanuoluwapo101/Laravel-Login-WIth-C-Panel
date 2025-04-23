# ─────────────── Stage 1: Node builder ───────────────
FROM node:18 AS node_builder

WORKDIR /app

# Copy only package files, install deps, build assets
COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build    # builds Tailwind & Livewire assets into public/build

# ─────────────── Stage 2: PHP runtime ───────────────
FROM php:8.2-fpm

# Install PHP extensions & system tools
RUN apt-get update && apt-get install -y \
    apt-utils \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy your application code
COPY . .

# Copy built assets from node_builder
COPY --from=node_builder /app/public/build ./public/build

# Install PHP deps
RUN composer install --no-dev --optimize-autoloader

# Permissions & storage link
RUN chmod -R 775 storage bootstrap/cache \
 && php artisan storage:link

# Cache everything
RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# Expose port & serve
EXPOSE 8000
CMD ["php","artisan","serve","--host=0.0.0.0","--port=8000"]
