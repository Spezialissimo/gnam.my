FROM php:7.4-apache

# Installa le estensioni di MySQL necessarie
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Installa Composer (gestore delle dipendenze PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia i file del progetto nella directory del server web
COPY . /var/www/html/

# Installazione di phpdotenv tramite Composer (per caricare il file .env)
WORKDIR /var/www/html/
RUN composer require vlucas/phpdotenv

# Espone la porta 80
EXPOSE 80
