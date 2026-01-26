FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
        git \
        unzip \
        icu-dev \
        libzip-dev \
        mariadb-connector-c-dev \
    && docker-php-ext-install \
        intl \
        pdo_mysql \
        zip \
        opcache

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
