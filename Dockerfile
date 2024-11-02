FROM php:apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    curl \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql gd exif

RUN a2enmod rewrite

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY app/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html/

EXPOSE 80
