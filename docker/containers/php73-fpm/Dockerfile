FROM devilbox/php-fpm:7.3-base

RUN apt-get update && \
    apt-get install libonig-dev libzip-dev libxml2-dev libfreetype6-dev libjpeg62-turbo-dev libmcrypt-dev cron zip vim libcurl4-openssl-dev pkg-config libssl-dev -y \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) iconv soap mysqli mbstring gd\
    && docker-php-ext-install pdo_mysql xml zip fileinfo\
    && docker-php-ext-configure intl\
    && docker-php-ext-install intl\
    && docker-php-ext-install exif\
    && docker-php-ext-install bcmath\
    && docker-php-ext-install pcntl\
    && pecl install mongodb && docker-php-ext-enable mongodb

# composer
RUN curl --silent --show-error https://getcomposer.org/composer.phar > composer.phar \
    && mv composer.phar /usr/bin/composer
RUN chmod +x /usr/bin/composer

# phpunit
RUN composer global require "phpunit/phpunit"
ENV PATH /root/.composer/vendor/bin:$PATH
RUN ln -s /root/.composer/vendor/bin/phpunit /usr/bin/phpunit

# xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

#RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# node
RUN apt-get install -y gnupg2
RUN curl -sL https://deb.nodesource.com/setup_11.x | bash -
RUN apt-get install -y nodejs
#RUN apt-get install -y npm

EXPOSE 9000
CMD ["php-fpm", "-F"]