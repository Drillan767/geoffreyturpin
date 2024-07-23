FROM php:8-fpm

RUN apt-get update -y && apt-get install -y \
    curl \
    openssl \
    zip \
    unzip \
    git \
    libonig-dev \
    zlib1g-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev

RUN useradd -ms /bin/bash gt2

WORKDIR /app
RUN chmod -R 777 /app
COPY --chown=gt2:gt2 . /app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN apt-get -yqq install exiftool
RUN docker-php-ext-configure exif
RUN docker-php-ext-install mysqli pdo pdo_mysql exif
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd
RUN composer install

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get update && apt-get install -y nodejs

CMD php artisan serve --host=0.0.0.0 --port=8080
EXPOSE 8080
