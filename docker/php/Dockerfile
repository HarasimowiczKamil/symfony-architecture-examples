FROM php:8.2-fpm

RUN apt-get update \
 && apt-get install -y \
    nginx \
    supervisor \
    # dev helpers
    mc \
    nano \
    procps \
    wget

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions \
 && install-php-extensions pdo

COPY ./nginx/default.conf /etc/nginx/sites-available/default
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# composer
RUN wget https://getcomposer.org/installer -O - -q | php -- \
 && mv composer.phar /usr/bin/ \
 && ln -s /usr/bin/composer.phar /usr/bin/composer


RUN openssl req -x509 -nodes -days 365 -subj "/C=CA/ST=QC/O=Company, Inc./CN=localhost" -addext "subjectAltName=DNS:localhost" -newkey rsa:2048 -keyout /etc/ssl/private/nginx-selfsigned.key -out /etc/ssl/certs/nginx-selfsigned.crt

EXPOSE 80 443

WORKDIR /var/www

CMD ["/usr/bin/supervisord", "-n"]
