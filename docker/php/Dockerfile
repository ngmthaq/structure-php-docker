FROM php:8.1-fpm

USER root

RUN apt-get update -y

RUN apt-get install git -y

RUN apt-get install zip unzip -y

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql

COPY --from=composer:2.1.8 /usr/bin/composer /usr/local/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && apt-get install -y nodejs

RUN npm i -g yarn