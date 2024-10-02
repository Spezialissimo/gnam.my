# Usa l'immagine base PHP con Apache
FROM php:7.4-apache

# Installa le estensioni di MySQL necessarie
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia il file composer.json e composer.lock (se presente) nella directory di lavoro
COPY composer.json /var/www/html/
COPY composer.lock /var/www/html/

# Installa Composer (usando l'immagine Composer per semplificare il processo)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Imposta la directory di lavoro
WORKDIR /var/www/html/

# Esegui il comando per installare le dipendenze di Composer
RUN composer install --no-interaction --no-scripts --prefer-dist

# Copia il resto dei file del progetto nella directory del server web
COPY . /var/www/html/

# Espone la porta 80
EXPOSE 80
