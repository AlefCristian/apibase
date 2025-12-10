FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libicu-dev libzip-dev zip unzip git \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl mysqli pdo pdo_mysql zip

# Instalar Composer dentro da imagem
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar o código antes do composer install
COPY . /var/www/html

# Instalar dependências
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN a2enmod rewrite
