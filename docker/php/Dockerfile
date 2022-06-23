FROM php:8.1.7-cli-alpine3.16 as builder

RUN apk add --no-cache --repository http://dl-3.alpinelinux.org/alpine/edge/community
RUN apk update && apk upgrade
RUN apk --no-cache add  \
    git \
    # Autoconf
    autoconf\
    dpkg-dev \
    dpkg \
    file \
    g++ \
    gcc \
    libc-dev \
    make \
    pkgconf \
    re2c \
    # Zip
    libzip-dev \
    curl \
    libcurl \
    curl-dev \
    # Intl
    icu-libs \
    icu-dev \
    postgresql-dev \
    bash \
    # AMQP
    rabbitmq-c \
    rabbitmq-c-dev

RUN docker-php-ext-install \
            pdo_pgsql \
            bcmath \
            zip \
            intl

RUN pecl install \
        apcu-5.1.21 \
        igbinary-3.1.6 \
        amqp-1.11.0

RUN docker-php-ext-enable \
        apcu \
        igbinary \
        amqp

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash
RUN apk add --no-cache symfony-cli

COPY php.ini /usr/local/etc/php/php.ini

FROM php:8.1.7-cli-alpine3.16 as prod

RUN adduser -D app

RUN apk update && apk upgrade
RUN apk --no-cache add \
    freetype \
    # Zip
    zip \
    libzip \
    # Curl ext
    curl \
    libcurl \
    # SimpleXML
    libxml2 \
    # Intl
    icu-libs \
    # pgsql
    libpq \
    # amqp
    rabbitmq-c \
    libzip


RUN ln -s /usr/local/bin/php /usr/local/bin/php8.1

COPY --from=builder /usr/local/etc/php /usr/local/etc/php
COPY --from=builder /usr/local/lib/php/extensions/no-debug-non-zts-20210902/ /usr/local/lib/php/extensions/no-debug-non-zts-20210902

FROM prod as dev

COPY --from=builder /usr/bin/symfony /usr/bin/symfony

RUN apk update && apk upgrade
RUN apk --no-cache add \
    # dev deps
    curl nano git openssh

COPY install-composer.sh /usr/local/bin/install-composer.sh
RUN chmod a+x /usr/local/bin/install-composer.sh
RUN /usr/local/bin/install-composer.sh
RUN rm /usr/local/bin/install-composer.sh

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod a+x /usr/local/bin/entrypoint.sh

WORKDIR /app
