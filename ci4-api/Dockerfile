# Use a imagem oficial do PHP com Apache
FROM php:8.1-apache

# Limpa o cache do APT
RUN apt-get clean

# Atualiza a lista de pacotes
RUN apt-get update

# Instala as dependências da extensão intl
RUN apt-get install -y \
    libicu-dev \
    zlib1g-dev \
    g++ \
    make

# Instala as extensões necessárias do PHP
RUN apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    unzip \
    git \
    curl \
    mariadb-client

# Habilita as extensões do PHP
RUN docker-php-ext-configure intl
RUN docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mysqli intl

# Habilita o mod_rewrite do Apache
RUN a2enmod rewrite

# Define o diretório de trabalho
WORKDIR /var/www/html/public_html/eSchool

# Copia a configuração do Apache
COPY ./docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copia os arquivos do CodeIgniter 4 para o container
COPY ./ /var/www/html/public_html/eSchool/

# Define as permissões corretas
RUN chown -R www-data:www-data /var/www/html/public_html/eSchool
RUN chmod -R 775 /var/www/html/public_html/eSchool/writable

# Instala o composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala as dependências do PHP
RUN composer install

# Define o diretório public como o diretório raiz do Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public_html/eSchool/public