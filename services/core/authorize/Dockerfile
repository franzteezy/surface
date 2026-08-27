FROM wyveo/nginx-php-fpm:php81

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

COPY . /usr/share/nginx/html
COPY ./nginx/default.conf /etc/nginx/conf.d/
COPY ./nginx/ssl /etc/nginx/ssl/
COPY ./nginx/runningProcess.sh /runningProcess.sh
COPY ./nginx/start.sh /start.sh
RUN chmod +x /start.sh

RUN composer install --working-dir=/usr/share/nginx/html
RUN apt-get update && apt-get -y install \
    cron \
    && rm -rf /var/lib/apt/lists/*
RUN echo "* * * * * cd /usr/share/nginx/html && php artisan schedule:run >> ka.log 2>&1" >> mycron
RUN echo "* * * * * sh /runningProcess.sh >ka.log 2>&1" >> mycron
RUN echo "10 * * * * rm /ka.log" >> mycron
RUN crontab mycron
