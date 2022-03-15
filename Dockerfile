FROM jameswade/php7.3-fpm-alpine

WORKDIR /app
COPY . .

RUN composer update

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0"]