FROM wyveo/nginx-php-fpm:php81

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
RUN useradd stafflify
RUN echo 'stafflify:83a27dcfa49615cca7cace7d20c71871' | chpasswd

COPY . /usr/share/nginx/html
COPY ./nginx /etc/nginx/conf.d/
COPY ./nginx/ssl /etc/nginx/ssl/
