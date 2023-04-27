FROM php:7.2-alpine

WORKDIR /app
#RUN php ./composer.phar update
RUN docker-php-ext-install -j$(nproc) pdo_mysql
RUN docker-php-ext-install -j$(nproc) pcntl pdo_mysql
EXPOSE 8000
CMD ./bin/console server:run 0.0.0.0:8000
