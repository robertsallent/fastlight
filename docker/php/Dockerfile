# =========================================================
# PHP8.2 con Apache
# =========================================================
# ./docker/php/Dockerfile
ARG PHP_VERSION=8.2-apache
FROM php:${PHP_VERSION}

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    sendmail \
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
	
# Configurar GD correctamente
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp 

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

# Configuración de correo
RUN echo "sendmail_path=/usr/sbin/sendmail -t -i" > /usr/local/etc/php/conf.d/mail.ini

# Configurar el DocumentRoot a /var/www/html/public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Reescribir la configuración de Apache para usar public/ como raíz
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar el código de la app dentro del contenedor
COPY . .

# Dar permisos (opcional)
RUN chown -R www-data:www-data /var/www/html

# Exponer puerto 80
EXPOSE 80