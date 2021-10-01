FROM php:8.0-fpm-alpine AS php

FROM php AS s6overlay

# install s6 overlay
RUN set -eux; \
    curl -sL https://github.com/just-containers/s6-overlay/releases/download/v2.2.0.3/s6-overlay-amd64.tar.gz -o /tmp/s6overlay.tar.gz; \
    tar xzf /tmp/s6overlay.tar.gz -C /; \
    rm /tmp/s6overlay.tar.gz;
ENV S6_KEEP_ENV=1;
ENV S6_BEHAVIOUR_IF_STAGE2_FAILS=2;
ENV S6_SYNC_DISKS=1;

FROM s6overlay AS base

WORKDIR /app

RUN set -eux; \
    apk update; \
    apk add git; \
    apk add zip; \
    apk add unzip; \
    apk add nginx; \
    apk add supervisor; \
    apk add tzdata; \
    apk add autoconf; \
    mkdir -p /run/nginx;

COPY docker/rootfs/ /

# Install composer
COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer
ENV PATH="${PATH}:/root/.composer/vendor/bin"
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_MEMORY_LIMIT=-1
ARG COMPOSER_AUTH="{}"


RUN apk --no-cache add pcre-dev ${PHPIZE_DEPS}
# postgres driver
RUN apk add --no-cache postgresql-dev; \
    docker-php-ext-install pdo_pgsql;

# Set timezone
RUN cp /usr/share/zoneinfo/Europe/Warsaw /etc/localtime
RUN echo "Europe/Warsaw" > /etc/timezone

RUN ln -s $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini
RUN sed -i 's/;date.timezone =/date.timezone = "Europe\/Warsaw"/g' $PHP_INI_DIR/php.ini

# Install Xdebug

RUN pecl install xdebug && docker-php-ext-enable xdebug

#cleanup
RUN apk del pcre-dev ${PHPIZE_DEPS}

CMD ["/init"]
EXPOSE 80