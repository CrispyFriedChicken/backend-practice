FROM php:7.2-fpm
COPY . /var/www
WORKDIR /var/www
#安裝相關套件
RUN apt-get update
RUN apt-get -y install git \
                       zip \
                       npm \
                       libmcrypt-dev \
                       graphviz \
                       nano \
                       cron \
                       libmagickwand-dev --no-install-recommends
RUN  pecl install mcrypt-1.0.2 \
        && docker-php-ext-install pdo_mysql \
        && docker-php-ext-enable mcrypt
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#建立設定檔
RUN mv .env.prod .env
#安裝vendor
RUN composer update
RUN composer install
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www/storage
#安裝node_modules
RUN npm install npm@latest -g
RUN npm install
RUN npm run dev
#清除快取
RUN php artisan cache:clear
RUN php artisan route:clear
RUN php artisan config:clear
#設定排程相關資訊
COPY ./crontab /var/spool/cron/crontabs/root
RUN chown -R root:crontab /var/spool/cron/crontabs/root
RUN chmod 600 /var/spool/cron/crontabs/root
COPY ./entrypoint.sh /usr/local/bin/
ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
