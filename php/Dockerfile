FROM php:7.4.13-apache

RUN apt-get update && \
    apt-get upgrade -fyqq

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin && \
    composer 

ENV COMPOSER_ALLOW_SUPERUSER 1

# Install additional PHP libraries
RUN docker-php-ext-install bcmath pdo_mysql

WORKDIR /app

COPY ./ /app

RUN chmod 777 -R /app

RUN ls -la /app/

RUN cd /app

RUN mkdir -p files/photo