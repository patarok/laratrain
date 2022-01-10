FROM php:8.0-fpm

# Locales
RUN apt-get update && apt-get install -y locales && \
    echo 'en_US.UTF-8 UTF-8' >> /etc/locale.gen  && \
    echo 'en_US ISO-8859-1' >> /etc/locale.gen  && \
    echo 'de_AT.UTF-8 UTF-8' >> /etc/locale.gen  && \
    echo 'de_AT ISO-8859-1' >> /etc/locale.gen  && \
    echo 'de_DE.UTF-8 UTF-8' >> /etc/locale.gen  && \
    echo 'de_DE ISO-8859-1' >> /etc/locale.gen  && \
    locale-gen \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# GD Library
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev libjpeg-dev \
    libzip-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Utils
RUN apt-get update && apt-get install -y --no-install-recommends \
    iputils-ping \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Intl Library
RUN apt-get update -y && apt-get install -y --no-install-recommends \
  libicu-dev \
  && docker-php-ext-configure intl \
  && docker-php-ext-install intl \
  && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pcntl

RUN docker-php-ext-install zip

RUN docker-php-ext-install bcmath

RUN docker-php-ext-install exif

# Mysql Dependencies
RUN docker-php-ext-install pdo pdo_mysql

# Image manipulation
RUN apt-get update && apt-get install -y libonig-dev libmpdec-dev libpng-dev libjpeg-dev libfreetype6-dev && \
 apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd


# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Composer cache
RUN mkdir -p /.composer/cache && chmod -R 777 /.composer/cache


# Utils
RUN apt-get update && apt-get install -y --no-install-recommends \
    unzip \
    git \
    wget \
    openssh-client \
    cron \
    default-mysql-client \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN pecl install xdebug; \
    docker-php-ext-enable xdebug;
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    echo "client_host=172.17.0.1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
    echo "xdebug.client_port=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini;

RUN cd /opt && \
 wget https://phar.phpunit.de/phpunit-9.phar && \
 chmod +x phpunit-9.phar && \
 mv phpunit-9.phar /usr/local/bin/phpunit


ENV COMPOSER_HOME=/.composer

# Arguments defined in docker-compose.yml
ARG USER_ID
ARG GROUP_ID

# Create system user to run Composer and Artisan Commands
RUN if [ ${USER_ID:-0} -ne 0 ] && [ ${GROUP_ID:-0} -ne 0 ]; then \
    userdel -f www-data &&\
    if getent group www-data ; then groupdel www-data; fi &&\
    groupadd -g ${GROUP_ID} www-data &&\
    useradd -l -u ${USER_ID} -g www-data www-data &&\
    install -d -m 0755 -o www-data -g www-data /home/www-data &&\
    chown --changes --silent --no-dereference --recursive \
          --from=33:33 ${USER_ID}:${GROUP_ID} \
        /home/www-data \
        /.composer \
;fi

RUN apt-get update && apt-get install -y libonig-dev libmpdec-dev libcurl4-openssl-dev libxml2-dev&& \
 apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

# TODO: Replace after release
#RUN docker-php-ext-install xmlrpc
RUN pecl install xmlrpc-1.0.0RC2; \
    docker-php-ext-enable xmlrpc;


RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

RUN locale-gen de_AT.UTF-8
ENV LANG de_AT.UTF-8
ENV LANGUAGE de_AT:en
ENV LC_ALL de_AT.UTF-8


# Set working directory
WORKDIR /var/www

USER www-data
