# Base stage
FROM php:8.3-cli as base

# Retrieve APT lists and install dependencies
RUN apt-get update \
    && apt-get install -y \
    libzip-dev \
    zip \
    git \
    libpq-dev \
    procps \
    libbrotli-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions using PECL and docker-php-ext-install
RUN pecl install \
    swoole \
    redis \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pcntl \
    opcache \
    gd \
    # mbstring \
    # exif \
    zip \
    # intl \
    # xsl \
    && docker-php-ext-enable \
    swoole \
    redis \
    pcntl \
    gd

# Install Composer binary
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configure OPcache environment variables
ENV OPCACHE_ENABLE=disable
ENV OPCACHE_ENABLE_CLI=0
ENV OPCACHE_JIT=tracing

# Specify working directory
WORKDIR /app

# Dev stage
FROM base AS base-dev

# Install Xdebug extension
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug


# Build stage
FROM base AS build

# Specify environment variable for .env file
ENV APP_ENV=production

# Configure OPcache environment variables
ENV OPCACHE_ENABLE=1
ENV OPCACHE_ENABLE_CLI=1
ENV OPCACHE_JIT=tracing

# Copy application files
COPY --chown=www-data:www-data . .

# Specify filesystem permissions
RUN chmod -R 775 bootstrap/cache storage

# Install Composer dependencies
RUN composer install \
    --no-interaction \
    --no-dev \
    --optimize-autoloader

# Optimize config loading
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan event:cache
