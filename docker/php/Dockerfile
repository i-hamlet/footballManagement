FROM php:8.2.7-fpm

RUN apt-get update && apt-get install -y libpq-dev \
    zip\
    unzip\
    nodejs\
    npm\
 && docker-php-ext-install pdo pdo_mysql \
 && apt-get install -y vim \
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 9000

