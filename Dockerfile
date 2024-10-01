# Usa l'immagine ufficiale di PHP con Apache
FROM php:7.4-apache

# Installa estensioni necessarie per MySQL
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia il contenuto della cartella corrente nel server web del container
COPY . /var/www/html/

# Imposta i permessi corretti per i file PHP
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Abilita il modulo di riscrittura di Apache
RUN a2enmod rewrite

# Espone la porta 80 per il servizio web
EXPOSE 80
