FROM php:7.3.24-apache-stretch



RUN apt-get update

# Install tools required for build stage
RUN apt-get install -fyqq \
    bash curl wget rsync ca-certificates openssl ssh git tzdata openntpd \
    libxrender1 fontconfig libc6 \
    mariadb-client gnupg binutils-gold autoconf \
    g++ gcc gnupg libgcc1 linux-headers-amd64 make python

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin && \
    composer 

ENV COMPOSER_ALLOW_SUPERUSER 1


# Install additional PHP libraries
RUN docker-php-ext-install bcmath pdo_mysql

# Install libraries for compiling GD, then build it
RUN apt-get install -fyqq libfreetype6 libfreetype6-dev libpng16-16 libpng-dev libjpeg62-turbo libjpeg62-turbo-dev \
    && docker-php-ext-install gd \
    && apt-get remove -fyqq libfreetype6-dev libpng-dev libjpeg62-turbo-dev

# Add ZIP archives support
RUN apt-get install -fyqq zip libzip-dev \
    && docker-php-ext-install zip \
    && apt-get remove -fyqq

WORKDIR /var/www/html

RUN mkdir /var/www/html/files/photo

RUN chmod 777 /var/www/html/files/photo