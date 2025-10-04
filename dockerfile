# Используем официальный PHP образ с Apache
FROM php:8.1-apache

# Устанавливаем системные зависимости
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    default-mysql-client

# Очищаем кеш
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Устанавливаем PHP расширения
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Включаем mod_rewrite для Apache
RUN a2enmod rewrite

# Копируем конфигурацию Apache
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Копируем файлы проекта
COPY . .

# Устанавливаем права на запись для папок
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/runtime \
    && chmod -R 777 /var/www/html/web/uploads \
    && chmod -R 777 /var/www/html/web/assets

# Устанавливаем зависимости
RUN composer install --no-dev --optimize-autoloader

# Экспонируем порт
EXPOSE 80

CMD ["apache2-foreground"]