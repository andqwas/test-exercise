FROM php:8.3-fpm

# построчное выполнение линуксовых команд
RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      zip unzip \
      git && \
      docker-php-ext-install pdo_pgsql && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# копируем свой php.ini в контейнер
COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

# устанавливаем композер, если вдруг он не был установлен внутри контейнера
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

# Копируем entrypoint
COPY _docker/app/entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

# рабочая директория; команды ниже (если будут) будут вызываться именно в ней
WORKDIR /var/www
