FROM php:7.2-apache

COPY package*.json ./

RUN apt-get update && apt-get install -y \
    curl

RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get install -y nodejs

RUN a2enmod rewrite

COPY . /var/www
WORKDIR /var/www

RUN npm install
RUN npm run build