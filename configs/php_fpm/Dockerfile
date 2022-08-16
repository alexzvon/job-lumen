FROM  php:8.1.6-fpm-alpine

#RUN echo "http://dl-cdn.alpinelinux.org/alpine/edge/main" >> /etc/apk/repositories \
#&& echo "http://dl-cdn.alpinelinux.org/alpine/edge/community" >> /etc/apk/repositories \
#&& echo "http://dl-cdn.alpinelinux.org/alpine/edge/testing" >> /etc/apk/repositories \

RUN apk update \
&& apk add --no-cache \
    git \
    autoconf \
    util-linux \
    g++ \
    automake \
    libtool \
    make \
    libxml2-dev \
    libpng-dev \
    imap-dev \
    postgresql-dev \
    libzip-dev \
    imagemagick-dev \
    imagemagick \
    pcre-dev \
    php-soap \
    grpc \
    protobuf \
    linux-headers \
&& docker-php-ext-install \
    bcmath \
    gd \
    imap \
    pcntl \
    mysqli \
    pdo_pgsql \
    pdo_mysql \
    zip \
    exif \
    soap \
&& pecl install imagick \
&& docker-php-ext-enable imagick \
&& pecl install redis \
&& docker-php-ext-enable redis \
&& pecl install grpc \
&& docker-php-ext-enable grpc \
&& pecl install protobuf \
&& docker-php-ext-enable protobuf \
&& set -eux; addgroup -g 1000 -S local; adduser --u 1000 -D -S -G local local; sed -i s/www-data/local/g /usr/local/etc/php-fpm.d/www.conf \
&& apk add py-pip \
&& apk add supervisor \
&& curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
&& composer config --global --auth gitlab-token.gitlab.com htpps://gitlab.com/profile/personal_access_tokens

#&& apk add --update nodejs nodejs-npm yarn \

ADD conf/php-fpm.ini /etc/supervisor.d/
#ADD conf/laravel-queue.ini conf/php-fpm.ini /etc/supervisor.d/
#ADD conf/php7/php.ini /etc/php7/
#ADD conf/php7/php.ini /usr/local/etc/php/

WORKDIR /var/www/backend

CMD ["supervisord", "-n"]
