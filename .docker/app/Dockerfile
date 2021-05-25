FROM php:8.0.3-fpm-alpine3.13

RUN apk add --no-cache shadow openssl bash mysql-client nodejs npm git supervisor
RUN docker-php-ext-install pdo pdo_mysql

ENV DOCKERIZE_VERSION v0.6.1
RUN wget https://github.com/jwilder/dockerize/releases/download/$DOCKERIZE_VERSION/dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz \
    && rm dockerize-linux-amd64-$DOCKERIZE_VERSION.tar.gz

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/

RUN rm -rf /var/www/html

COPY ./entrypoint.sh /docker-entrypoint.sh
COPY ./supervisor.conf /etc/supervisord.conf

RUN chmod +x /docker-entrypoint.sh

USER root

EXPOSE 9000