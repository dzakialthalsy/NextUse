FROM php:8.2-apache

# Install ekstensi PHP yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Copy Laravel ke direktori Apache
COPY . /var/www/html

WORKDIR /var/www/html/src

# Set permission
RUN chown -R www-data:www-data /var/www/html/src

RUN a2enmod rewrite

COPY apache.conf /etc/apache2/sites-enabled/000-default.conf
