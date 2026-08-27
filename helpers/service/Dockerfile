FROM wyveo/nginx-php-fpm:php81

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

COPY . /usr/share/nginx/html
COPY ./nginx/default.conf /etc/nginx/conf.d/
COPY ./nginx/ssl /etc/nginx/ssl/

RUN composer install --working-dir=/usr/share/nginx/html
