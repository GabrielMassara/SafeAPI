FROM php:8.2-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo_pgsql

COPY . .

CMD ["php", "-S", "0.0.0.0:8000", "index.php"]
