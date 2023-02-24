FROM composer:2.5.0 AS composer

FROM php:7.3-alpine
COPY --from=composer /usr/bin/composer /usr/bin/composer