FROM php:7.1-apache
WORKDIR /var/www/html

RUN docker-php-ext-install mbstring pdo pdo_mysql mysqli
RUN docker-php-ext-enable mysqli
RUN a2enmod rewrite

RUN mkdir /var/www/graficajobs
COPY . /var/www/graficajobs/
COPY ./public/.htaccess /var/www/graficajobs/public/.htaccess

RUN ln -s /var/www/graficajobs/public/* /var/www/html/
RUN ln -s /var/www/graficajobs/public/.htaccess /var/www/html/.htaccess
