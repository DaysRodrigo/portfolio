# ─────────────────────────────────────────────────────────────────────────────
# Stage 1 — Frontend assets (production only)
# ─────────────────────────────────────────────────────────────────────────────
FROM node:22-alpine AS frontend
WORKDIR /app
COPY package*.json vite.config.js tailwind.config.js postcss.config.js ./
COPY resources/ resources/
COPY public/ public/
RUN npm ci --no-audit && npm run build

# ─────────────────────────────────────────────────────────────────────────────
# Stage 2 — PHP dependencies without dev packages (production only)
# ─────────────────────────────────────────────────────────────────────────────
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
        --no-dev \
        --no-interaction \
        --prefer-dist \
        --optimize-autoloader \
        --no-scripts
COPY . .
RUN composer dump-autoload --no-dev --optimize

# ─────────────────────────────────────────────────────────────────────────────
# Stage 3 — Dev image (used by docker-compose.yml)
# ─────────────────────────────────────────────────────────────────────────────
FROM php:8.4-fpm AS dev

ARG UID=1000
ARG GID=1000

RUN groupmod -g ${GID} www-data \
    && usermod -u ${UID} -g ${GID} www-data

RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        curl \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        libzip-dev \
        zip \
        unzip \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        bcmath \
        pcntl \
        zip \
        xml \
        gd \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
USER www-data

# ─────────────────────────────────────────────────────────────────────────────
# Stage 4 — Production image (Alpine, no dev tools, pre-built assets)
# ─────────────────────────────────────────────────────────────────────────────
FROM php:8.4-fpm-alpine AS production

ARG UID=1000
ARG GID=1000

# Build deps needed only to compile PHP extensions + redis
RUN apk add --no-cache --virtual .build-deps \
        autoconf gcc g++ make \
        libpng-dev oniguruma-dev libxml2-dev libzip-dev \
    && apk add --no-cache \
        libpng oniguruma libxml2 libzip \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        bcmath \
        pcntl \
        zip \
        xml \
        gd \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps \
    && rm -rf /tmp/pear

RUN addgroup -g ${GID} -S portfolio \
    && adduser -u ${UID} -S -D -G portfolio portfolio

WORKDIR /var/www/html

COPY --from=vendor  --chown=portfolio:portfolio /app/vendor        ./vendor
COPY --from=frontend --chown=portfolio:portfolio /app/public/build  ./public/build
COPY --chown=portfolio:portfolio . .

RUN mkdir -p \
        storage/logs \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        bootstrap/cache \
    && chown -R portfolio:portfolio storage bootstrap/cache

USER portfolio
