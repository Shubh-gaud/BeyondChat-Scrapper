FROM php:8.4-apache

# Enable Apache rewrite
RUN a2enmod rewrite

# Set Laravel public folder as Apache root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

# Install system deps
RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

WORKDIR /var/www/html

# Copy project
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --optimize-autoloader

# Laravel permissions
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]
