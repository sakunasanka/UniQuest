# Use an official PHP image with Apache
FROM php:8.2-apache

# Install necessary PHP extensions for MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy project files to the container
COPY . .

# Copy the custom Apache configuration
COPY uniquest.conf /etc/apache2/sites-available/uniquest.conf

# Enable the custom configuration
RUN a2ensite uniquest.conf && a2dissite 000-default.conf

# Set file permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]