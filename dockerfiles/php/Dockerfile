FROM php:7.4-fpm

RUN apt-get update

RUN apt-get install -y librdkafka-dev

RUN pecl install channel://pecl.php.net/rdkafka-beta

RUN rm -rf /tmp/pear

RUN echo "extension=rdkafka.so" > /usr/local/etc/php/conf.d/rdkafka.ini

WORKDIR /var/www/html

CMD [ "php-fpm" ]