# Use official PHP image with built-in server
FROM php:8.2-cli

# Install MySQL PDO extension
RUN docker-php-ext-install pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

# Expose port
EXPOSE 8000

# Start PHP server directly from public directory
CMD ["sh", "-c", "cd public && php -S 0.0.0.0:8000"]
