# Dockerfile
# ReamurCMS — PHP 8.2 + Apache
#
# ⚠️  Fix from original: cp config-dist.php was running at build time
#     before the volume was mounted, overwriting configs on every build.
#     Config copy is now handled at container startup via docker-entrypoint.sh.

FROM php:8.2-apache

# ─────────────────────────────────────────
# System dependencies
# ─────────────────────────────────────────
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    libssl-dev \
    zip \
    unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# ─────────────────────────────────────────
# PHP extensions
# ─────────────────────────────────────────
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl \
    opcache

# Redis extension (via PECL) — used by ReamurCMS cache engine
RUN pecl install redis \
    && docker-php-ext-enable redis

# ─────────────────────────────────────────
# Composer
# ─────────────────────────────────────────
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ─────────────────────────────────────────
# Apache configuration
# ─────────────────────────────────────────
RUN a2enmod rewrite headers expires

# ─────────────────────────────────────────
# Working directory & permissions
# ─────────────────────────────────────────
WORKDIR /var/www/html

# Set correct ownership for Apache
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# ─────────────────────────────────────────
# Entrypoint script
# Handles first-run config copy and permission setup
# ─────────────────────────────────────────
COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["apache2-foreground"]
