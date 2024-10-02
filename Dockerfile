# Usa l'immagine base PHP con Apache
FROM php:7.4-apache

# Installa le estensioni di MySQL necessarie
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Installa Composer (utilizzando l'immagine di Composer)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Imposta la directory di lavoro
WORKDIR /var/www/html/

# Copia i file del progetto nella directory del server web
COPY . /var/www/html/

# Esegui il comando per installare le dipendenze, incluso phpdotenv
RUN composer install

# Espone la porta 80
EXPOSE 80
