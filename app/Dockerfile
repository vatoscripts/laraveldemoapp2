FROM php:7.3-fpm

#COPY composer.lock composer.json /var/www/biokyc/

WORKDIR /var/www/biokyc

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libzip-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy application folder
COPY . /var/www/biokyc-dev

# Copy existing permissions from folder to docker
COPY --chown=www:www . /var/www/biokyc-dev
RUN chown -R www-data:www-data /var/www/biokyc-dev

# change current user to www
USER www

EXPOSE 9000
CMD ["php-fpm"]
