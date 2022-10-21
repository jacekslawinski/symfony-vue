FROM php:8.1.10-apache
COPY ./apache.conf /etc/apache2/sites-enabled/000-default.conf
RUN a2enmod rewrite
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN apt-get update && apt-get install -y \
    bash \
    git \
    zip \
    software-properties-common \
    npm && \
    pecl install xdebug-3.1.5 && \
    docker-php-ext-install mysqli pdo_mysql && \
    docker-php-ext-enable pdo_mysql mysqli xdebug && \
    npm install npm@latest -g && \
    npm install n -g && \
    n latest
COPY ./xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
WORKDIR /app
ENTRYPOINT ["/app/bin/build.sh"]
