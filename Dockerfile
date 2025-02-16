# Use an official PHP image with Apache
FROM php:8.2-apache

# Set the working directory
WORKDIR /var/www/html

# Install necessary PHP extensions for PHPMailer
# RUN docker-php-ext-install pdo pdo_mysql openssl sockets

# Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer.json and composer.lock
# COPY composer.json composer.lock ./

# Install dependencies
# RUN composer install --no-dev --optimize-autoloader

# Copy the rest of your project files
COPY . .

# Enable Apache rewrite module for .htaccess
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80