# Usar uma imagem oficial do PHP 8.2 com Apache
FROM php:8.2-apache

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Instalar Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Habilitar mod_rewrite do Apache
RUN a2enmod rewrite

# Definir o diretório de trabalho no contêiner
WORKDIR /var/www/html

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar o código do Laravel para dentro do contêiner
COPY . /var/www/html

# Ajustar permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Instalar as dependências do Laravel
RUN composer install --no-scripts --no-autoloader

# Rodar a otimização e criar o autoloader do Laravel
RUN composer dump-autoload --optimize

# Expor a porta 80
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]

