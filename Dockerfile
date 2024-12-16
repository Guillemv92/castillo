# Usa una imagen oficial de PHP con soporte para CLI
FROM php:8.1-cli

# Instala dependencias del sistema y extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Instala Composer manualmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia los archivos del proyecto al contenedor
COPY . /var/www/html/

# Configura el directorio de trabajo en la carpeta del proyecto
WORKDIR /var/www/html

# Instala las dependencias de Composer (optimización para producción)
RUN composer install --no-dev --optimize-autoloader

# Expón el puerto 9000 para el servidor embebido de PHP
EXPOSE 9000

# Comando para iniciar el servidor embebido de PHP
CMD ["php", "-S", "0.0.0.0:9000", "-t", "public"]
