FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set permissions
RUN chmod -R 775 storage bootstrap/cache

# Expose port
EXPOSE 10000

# Start command
CMD php artisan config:clear && \
    php artisan route:clear && \
    php artisan migrate --force 2>&1 && \
    php artisan db:seed --class=AdminSeeder --force 2>&1 && \
    php artisan storage:link 2>&1 && \
    php artisan serve --host=0.0.0.0 --port=10000
