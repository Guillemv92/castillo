# Usa una imagen oficial de PHP con soporte para Apache o FPM
FROM php:8.1-cli

# Instala dependencias necesarias para PHP (si es necesario)
RUN apt-get update && apt-get install -y \
    git \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Copia los archivos de tu proyecto al contenedor
COPY . /var/www/html/

# Configura el directorio de trabajo en la carpeta donde está el proyecto
WORKDIR /var/www/html

# Expón el puerto 9000 para el servidor embebido de PHP
EXPOSE 9000

# Comando para iniciar el servidor embebido de PHP en el puerto 9000
CMD ["php", "-S", "0.0.0.0:9000", "-t", "public"]
