# Basic setup to be used by other setups #
FROM php:7.2-alpine AS base

WORKDIR /var/www

RUN apk --update add \
  nginx \
  git \
  php7-fpm \
  php7-json \
  php7-openssl \
  php7-mcrypt \
  php7-ctype \
  php7-zlib \
  php7-curl \
  php7-phar \
  php7-xml \
  php7-opcache \
  php7-intl \
  php7-bcmath \
  php7-dom \
  php7-xmlreader \
  php7-mbstring \
  php7-iconv \
  php7-simplexml \
  php7-tokenizer \
  php7-session \
  php7-xmlwriter \
  curl \
  && rm -rf /var/cache/apk/* \
  &&  curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
  && chown www-data:www-data /var/www \
  && mkdir -p /run/nginx

RUN docker-php-ext-install mysqli pdo pdo_mysql

USER www-data

RUN composer global require "hirak/prestissimo:^0.3" --no-update \
    && composer global install --no-dev

USER root

EXPOSE 80

#CMD ["/usr/bin/supervisord"]

#----------------------------------#
# Setup for local development only #
#----------------------------------#
FROM base AS develop

RUN apk update \
    && echo "y" | apk add alpine-sdk mc vim git wget php7-dev autoconf \

    # xDebug
    && wget https://xdebug.org/files/xdebug-2.6.0.tgz \
    && tar -xvzf xdebug-2.6.0.tgz \
    && cd xdebug-2.6.0 \
    && phpize \
    && ./configure \
    && make && make install \
    && cd .. \
    # && [ -d "xdebug-2.6.0" ] && rm -rf ./xdebug-2.6.0 \
    # && [ -f "xdebug-2.6.0.tgz" ] && rm xdebug-2.6.0.tgz \
    # && [ -f "package.xml" ] && rm package.xml \ \
    && php -i | grep xdebug \

    # ast php extension for phan
    && wget https://github.com/nikic/php-ast/archive/v0.1.6.tar.gz \
    && tar -xvzf v0.1.6.tar.gz \
    && cd php-ast-0.1.6 \
    && phpize \
    && ./configure \
    && make && make install \
    && cd ..

#----------------------------------#
#        Setup for CI              #
#----------------------------------#
FROM base AS testing

WORKDIR /var/www

ADD . /var/www
ADD ./.env.test /var/www/.env

RUN composer install --no-interaction --no-progress

RUN mkdir -p /var/www/logs && chmod -R 777 /var/www/logs
