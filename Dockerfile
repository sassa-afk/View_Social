FROM php:8.1-apache

# Instala extensões do PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Ativa o módulo de rewrite do Apache
RUN a2enmod rewrite

# Altera o DocumentRoot para a pasta /public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf

# Copia os arquivos do projeto para dentro do container
COPY . /var/www/html/

# Permissões opcionais (ajuste se usar uploads)
RUN chown -R www-data:www-data /var/www/html/public/upload

# Expõe a porta padrão do Apache
EXPOSE 80

