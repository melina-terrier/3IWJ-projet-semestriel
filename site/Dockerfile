FROM php:8.2-apache

RUN apt-get update

# Install Postgre PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Install MySQL PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_mysql


RUN apt-get update -y && apt-get install -y libpng-dev libfreetype6-dev libyaml-dev

RUN  docker-php-ext-configure gd --with-freetype
RUN  docker-php-ext-install gd

RUN pecl install yamL

RUN usermod -u 1000 www-data

RUN a2enmod rewrite








# # Utilisation de l'image PHP 8.2 avec Apache
# FROM php:8.2-apache

# # Mise à jour et installation des dépendances nécessaires
# RUN apt-get update

# # Installation des extensions PHP nécessaires pour PHPMailer et autres dépendances
# RUN apt-get install -y \
#     libpq-dev \
#     libpng-dev \
#     libfreetype6-dev \
#     libyaml-dev \
#     && docker-php-ext-configure gd --with-freetype \
#     && docker-php-ext-install -j$(nproc) \
#     pdo pdo_pgsql pgsql \
#     gd

# # Installation de Composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # Activation du module Apache pour le rewriting d'URLs
# RUN a2enmod rewrite

# # Redémarrage du service Apache pour appliquer les modifications
# RUN service apache2 restart
