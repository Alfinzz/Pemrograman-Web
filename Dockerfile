# Base image: PHP 8.2 with FPM
FROM php:8.2-fpm


# Set Working Directory
WORKDIR /var/www/html

# Copy application files
COPY . .


# Prepare Laravel directories and storage symlink
RUN chown -R www-data:www-data /var/www/html 

# Remove default Nginx configuration and add custom config
RUN rm /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default \
    && mv /var/www/html/docker/nginx/default.conf /etc/nginx/sites-available/default \
    && ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/

# Expose port 80
EXPOSE 80

# Command to run both PHP-FPM and Nginx
CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]