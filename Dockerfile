# Use the Alpine variant for a minimal image
FROM php:8.3-apache

# Install git and any other required extensions
RUN apt-get update && apt-get install -y git \
    # You can add more extensions here if needed, e.g., libpng-dev
    # && docker-php-ext-install gd \
    # Clean up apt lists to reduce image size \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    zlib1g-dev \
    && rm -rf /var/lib/apt/lists/*

# Instalamos las extensiones de PHP necesarias para MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Set the working directory inside the container
WORKDIR /var/www/html

# Habilitamos el módulo rewrite de Apache (común en apps PHP)
#RUN a2enmod rewrite

# Copiamos los archivos del proyecto al contenedor
COPY . /var/www/html/

# Copia el archivo de ejemplo al nombre real si no existe
RUN cp /var/www/html/config.example.php /var/www/html/config.php

# Ajustamos permisos para que Apache pueda leer los archivos
RUN chown -R www-data:www-data /var/www/html