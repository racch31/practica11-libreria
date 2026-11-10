FROM php:8.2-apache

# Extensiones para conectar PHP con MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Permitir subir portadas de hasta 5 MB
RUN { \
      echo "upload_max_filesize = 5M"; \
      echo "post_max_size = 6M"; \
    } > /usr/local/etc/php/conf.d/uploads.ini
