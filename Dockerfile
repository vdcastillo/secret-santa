# Usamos una imagen oficial de PHP con Apache
FROM php:8.1-apache

# Instalamos las extensiones de PHP necesarias para MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Habilitamos el módulo rewrite de Apache (común en apps PHP)
RUN a2enmod rewrite

# Copiamos los archivos del proyecto al contenedor
COPY . /var/www/html/

# Ajustamos permisos para que Apache pueda leer los archivos
RUN chown -R www-data:www-data /var/www/html