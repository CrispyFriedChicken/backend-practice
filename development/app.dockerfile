FROM php:7.2-fpm
COPY composer.lock composer.json /var/www/
COPY database /var/www/database
COPY . /var/www
WORKDIR /var/www
RUN apt-get update
RUN apt-get -y install git \
                       zip \
                       npm \
                       libmcrypt-dev \
                       libmagickwand-dev --no-install-recommends
RUN  pecl install mcrypt-1.0.2 \
        && docker-php-ext-install pdo_mysql \
        && docker-php-ext-enable mcrypt
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN mv .env.prod .env
RUN composer install
RUN composer update
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage
RUN npm install npm@latest -g
RUN npm install
RUN npm run dev
RUN php artisan optimize
#RUN php artisan cache:clear
#RUN php artisan route:clear
#RUN php artisan config:clear
#RUN php artisan migrate
