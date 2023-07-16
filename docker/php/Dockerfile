FROM php:8.1-fpm

WORKDIR /var/www/html/

RUN apt update -y

RUN apt install git zip unzip libmariadb-dev -y

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql

COPY --from=composer:2.1.8 /usr/bin/composer /usr/local/bin/composer/

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && apt install -y nodejs

RUN npm i -g yarn

RUN chown -R www-data:www-data /var/www/html/
