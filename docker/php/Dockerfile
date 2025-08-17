# =========================================================
# PHP8.2 con Apache
# =========================================================

# carga la imagen indicada en el fichero .env (8.2-apache)
ARG php_version
FROM php:${php_version}


RUN apt-get update && apt-get install --no-install-recommends -y \
  libzip-dev \
  libxml2-dev \
  mariadb-client \
  zip \
  unzip \
  && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN pecl install zip pcov
RUN docker-php-ext-enable zip \
  && docker-php-ext-install pdo_mysql \
  && docker-php-ext-install mysqli \
  && docker-php-ext-install zip \
  && docker-php-ext-install fileinfo \
  && docker-php-ext-install bcmath \
  && docker-php-ext-install soap \
  && docker-php-source delete

RUN a2enmod rewrite \
  && a2dissite * \
  && a2disconf other-vhosts-access-log

# modifica la configuracion de Apache
COPY config/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY config/docker-php.conf /etc/apache2/conf-available/docker-php.conf
COPY config/apache2.conf /etc/apache2/apache2.conf

# configuracion del php
COPY config/php.ini-development "$PHP_INI_DIR/php.ini"

# instalar composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# instalar postfix
RUN echo "postfix postfix/mailname string test.example" | debconf-set-selections
RUN echo "postfix postfix/main_mailer_type string 'Internet Site'" | debconf-set-selections
RUN apt-get update && apt-get install --no-install-recommends -y postfix

CMD ["apache2-foreground"]
