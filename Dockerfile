# 1. Use PHP 8.2 with Apache
FROM php:8.2-apache

# 2. Install dependencies (Zip, Git, Postgres Libs)
# [UPDATED] libpq-dev যুক্ত করা হয়েছে PostgreSQL এর জন্য
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev

# 3. Install Node.js (For Vue/Tailwind build)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

# 4. Install PHP Extensions
# [UPDATED] pdo_mysql এর বদলে pdo_pgsql দেওয়া হয়েছে
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd zip

# 5. Configure Apache Document Root to /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 6. Enable Apache Rewrite Module
RUN a2enmod rewrite

# 7. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 8. Set Working Directory
WORKDIR /var/www/html

# 9. Copy Project Files
COPY . .

# 10. Install PHP & Node Dependencies
RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

# 11. Set Permissions
RUN chown -R www-data:www-data storage bootstrap/cache
