FROM php:8.1-fpm

USER root

COPY --from=composer:2.1.8 /usr/bin/composer /usr/local/bin/composer

RUN apt-get update -y

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && apt-get install -y nodejs

RUN npm i -g yarn