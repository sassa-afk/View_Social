FROM php:8.1-apache

# Instala extensões PHP necessárias para MySQL e PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql pgsql pdo_pgsql

# Ativa módulo de rewrite do Apache
RUN a2enmod rewrite

# Ajusta DocumentRoot para apontar para a pasta /public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Copia o projeto pro container
COPY . /var/www/html/

# Permissões (ajuste se tiver uploads)
RUN chown -R www-data:www-data /var/www/html/public/upload

# Expõe a porta padrão
EXPOSE 80

