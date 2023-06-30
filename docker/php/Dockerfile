FROM php:8.1-fpm

COPY --from=composer:2.1.8 /usr/bin/composer /usr/local/bin/composer

RUN apt-get update -y