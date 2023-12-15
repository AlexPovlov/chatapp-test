FROM php:8.1-fpm

RUN apt-get update && apt-get install -y apt-utils libfreetype6-dev libjpeg62-turbo-dev libpq-dev libpng-dev libzip-dev zip unzip git && \
      docker-php-ext-configure gd --with-freetype --with-jpeg && \
      docker-php-ext-install pdo pdo_pgsql pgsql bcmath gd zip && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

WORKDIR /var/www
RUN chown -R www-data:www-data /var/www