# =========================================================
# PHP 8.4 con Apache
# =========================================================
# ./docker/php/Dockerfile

ARG PHP_VERSION=8.4-apache
FROM php:${PHP_VERSION}

# Activar configuración PHP para desarrollo
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    msmtp \
    msmtp-mta \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libjpeg62-turbo-dev \
    libwebp-dev \
    libgif-dev \
    libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*

# Configurar GD
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp

# Instalar extensiones PHP
RUN docker-php-ext-install \
    pdo_mysql \
    mysqli \
    intl \
    zip \
    gd \
    soap \
    opcache

# Habilitar mod_rewrite de Apache
RUN a2enmod rewrite

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# =========================================================
# Configuración de correo con Mailpit
# =========================================================

# Configurar msmtp para enviar mediante el servicio "mailpit"
RUN printf '%s\n' \
    'defaults' \
    'auth off' \
    'tls off' \
    'logfile /tmp/msmtp.log' \
    '' \
    'account mailpit' \
    'host mailpit' \
    'port 1025' \
    'from noreply@example.test' \
    '' \
    'account default : mailpit' \
    > /etc/msmtprc \
    && chmod 644 /etc/msmtprc

# Indicar a PHP que mail() debe utilizar msmtp
RUN echo 'sendmail_path="/usr/bin/msmtp -t -i"' \
    > /usr/local/etc/php/conf.d/mail.ini

# Configurar el DocumentRoot
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Reescribir la configuración de Apache
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
        /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' \
        /etc/apache2/apache2.conf \
        /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

COPY . .

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80