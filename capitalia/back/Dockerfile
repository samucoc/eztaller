FROM php:7.2-apache

# Copiar composer.lock y composer.json
COPY composer.lock composer.json /var/www/

# Instalamos dependencias
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libxml2-dev \
    libpq-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    libaio1 \
    wget \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

RUN mkdir /opt/oracle && \
    cd /opt/oracle && \
    wget https://github.com/bumpx/oracle-instantclient/raw/master/instantclient-basic-linux-x86-64-11.2.0.2.0.zip && \
    wget https://github.com/bumpx/oracle-instantclient/raw/master/instantclient-sdk-linux-x86-64-11.2.0.2.0.zip && \
    unzip instantclient-basic-linux-x86-64-11.2.0.2.0.zip && \
    unzip instantclient-sdk-linux-x86-64-11.2.0.2.0.zip && \
    ln -s /opt/oracle/instantclient_11_2/libclntsh.so.11.1 /opt/oracle/instantclient_11_2/libclntsh.so && \
    ln -s /opt/oracle/instantclient_11_2/libocci.so.11.1 /opt/oracle/instantclient_11_2/libocci.so && \
    rm -rf /opt/oracle/*.zip && \
    echo /opt/oracle/instantclient_11_2 > /etc/ld.so.conf.d/oracle-instantclient && \
    ldconfig

# Borramos cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

ENV LD_LIBRARY_PATH  /opt/oracle/instantclient_11_2:${LD_LIBRARY_PATH}

# Habilitamos el módulo rewrite
RUN a2enmod rewrite

# Instalamos extensiones
RUN echo 'instantclient,/opt/oracle/instantclient_11_2/' | pecl install oci8 \
    && docker-php-ext-enable oci8 \
    && docker-php-ext-configure pdo_oci --with-pdo-oci=instantclient,/opt/oracle/instantclient_11_2,11.2 \
    && docker-php-ext-install pdo_oci
RUN docker-php-ext-install mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd
RUN docker-php-ext-install soap

# agregar usuario para la aplicación laravel
# RUN groupadd -g 1000 www
# RUN useradd -u 1000 -ms /bin/bash -g www www

# Instalar composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar el directorio existente a /var/www
COPY . /var/www

# Configura el directorio raiz
WORKDIR /var/www

# Instalar dependencias
RUN composer install

# copiar los permisos del directorio de la aplicación
COPY --chown=www-data:www-data . /var/www