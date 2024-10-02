# Usa l'immagine base PHP con Apache
FROM php:7.4-apache

# Installa le estensioni necessarie per MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Imposta la directory di lavoro
WORKDIR /var/www/html/

# Copia il resto dei file del progetto nella directory del server web
COPY . /var/www/html/

# Espone la porta 80 per il traffico HTTP
EXPOSE 80
