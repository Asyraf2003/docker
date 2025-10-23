FROM php:8.3-fpm-alpine

# Tools & dev libs
RUN apk add --no-cache \
    bash git curl unzip \
    icu-dev oniguruma-dev \
    libpng-dev libjpeg-turbo-dev libwebp-dev \
    libzip-dev zlib-dev

# Ekstensi bawaan Laravel yang umum
RUN docker-php-ext-configure gd --with-jpeg --with-webp \
 && docker-php-ext-install -j$(nproc) \
    pdo_mysql bcmath intl gd zip mbstring exif opcache

# phpredis (karena REDIS_CLIENT=phpredis)
RUN apk add --no-cache $PHPIZE_DEPS \
 && pecl install redis \
 && docker-php-ext-enable redis \
 && apk del $PHPIZE_DEPS

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# php.ini dasar
RUN { \
  echo "memory_limit=512M"; \
  echo "upload_max_filesize=64M"; \
  echo "post_max_size=64M"; \
  echo "max_execution_time=120"; \
  echo "opcache.enable=1"; \
  echo "opcache.enable_cli=1"; \
  echo "opcache.validate_timestamps=1"; \
  echo "opcache.revalidate_freq=2"; \
  echo "date.timezone=Asia/Makassar"; \
} > /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www

# Pastikan permission direktori Laravel
RUN addgroup -g 82 -S www-data || true \
 && adduser -u 82 -D -S -G www-data www-data || true \
 && mkdir -p storage bootstrap/cache \
 && chown -R www-data:www-data storage bootstrap/cache

USER www-data

CMD ["php-fpm", "-F"]
