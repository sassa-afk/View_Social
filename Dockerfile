FROM php:8.1-apache

# Instala extensões PHP necessárias
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql pgsql pdo_pgsql

# Ativa módulo de rewrite do Apache
RUN a2enmod rewrite

# Copia os arquivos antes de alterar DocumentRoot
COPY . /var/www/html/

# Ajusta DocumentRoot para /public (DEPOIS do COPY!)
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Ajusta permissões (upload de arquivos)
RUN chown -R www-data:www-data /var/www/html/public/upload

# Configura erros e log
RUN echo "display_errors = Off" >> /usr/local/etc/php/conf.d/docker-php-production.ini \
 && echo "display_startup_errors = Off" >> /usr/local/etc/php/conf.d/docker-php-production.ini \
 && echo "log_errors = On" >> /usr/local/etc/php/conf.d/docker-php-production.ini \
 && echo "error_log = /var/log/php_errors.log" >> /usr/local/etc/php/conf.d/docker-php-production.ini

# Expõe a porta padrão
EXPOSE 80

