# Use the official PHP + Apache image
FROM php:8.2-apache

# Copy your app files into the Apache web root
COPY . /var/www/html/

# Install mysqli extension for MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Expose port 10000 (Render uses dynamic ports)
EXPOSE 10000

# Start the PHP built-in web server
CMD ["php", "-S", "0.0.0.0:10000", "-t", "/var/www/html"]
