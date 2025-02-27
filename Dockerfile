FROM --platform=linux/amd64 php:8.2-apache
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libmcrypt-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring gd zip
RUN a2enmod rewrite
RUN curl -sS https://getcomposer.org/installer | php -- --version=2.2.0 --install-dir=/usr/local/bin --filename=composer
COPY . /var/www/html
COPY apache-laravel.conf /etc/apache2/sites-available/000-default.conf
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache
WORKDIR /var/www/html
EXPOSE 83 