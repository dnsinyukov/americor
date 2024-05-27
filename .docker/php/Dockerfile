FROM php:8.2.19-fpm

WORKDIR /var/www

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN apt-get update && apt-get install -y --no-install-recommends \
    libxml2-dev \
	libfreetype6-dev \
	libjpeg62-turbo-dev \
	libjpeg-dev \
	libpq-dev \
	libmemcached-dev \
	libxslt-dev \
	curl \
	unzip \
	libzip-dev \
    libonig-dev \
    nano \
	git \
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install mbstring mysqli pdo pdo_mysql exif gettext pcntl shmop sockets sysvmsg sysvsem sysvshm xsl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY --chown=www:www . /var/www/html

USER www

EXPOSE 9000

CMD ["php-fpm"]