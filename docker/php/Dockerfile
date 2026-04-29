FROM php:8.4-fpm-alpine

# Argumentos para manejar permisos de usuario
ARG USER=www
ARG UID=1000

# Paquetes base + dependencias para extensiones
RUN apk add --no-cache \
    bash git curl unzip zip \
    icu-dev oniguruma-dev libzip-dev \
    libpng-dev libjpeg-turbo-dev freetype-dev

# Configurar e instalar extensiones
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo_mysql mbstring zip bcmath intl gd opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Crear usuario para evitar problemas de permisos
RUN adduser -D -u $UID -g $UID $USER
USER $USER

WORKDIR /var/www