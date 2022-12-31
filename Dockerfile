#FROM php:7.4-apache

#LABEL maintainer="Jaivic"

#RUN a2enmod rewrite

#RUN apt-get update && apt-get install -y \
#        zlibig-dev \
#        libicu-dev \
#        libxml2-dev \
#        libpq \
#        vim \
#        nano \
#        && docker-php-ext-install pdo pdo_mysql zip intl xmlrpc soap opcache \
#        && docker-php-ext-configure pdo_mysql --with-pdo-mysql-mysqlnd

#RUN curl -sL https://deb.nodesource.com/setup_8.x | bash -- \
#        && apt-get install -y nodejs \
#        && apt-get autoremove -y

#COPY --from=composer /usr/bin/composer /usr/bin/compose
#COPY docker/php/php.ini /usr/local/etc/php/
#COPY docker/apache/vhost.conf /usr/apache2/sites-availeble/000-default.conf
#COPY docker/apache/apache2.conf /etc/apache2/apache2.conf

#ENV COMPOSER_ALLOW_SUPERUSER 1

#COPY . /var/www/html/
#COPY docker/.env.prod /var/ww/html/.env
#WORKDIR /var/www/html/

#RUN chown -R www-data:www-data /var/www/html \
#        && composer install

#COPY . /var/www/html/

#RUN apt-get update

#RUN apt-get install nano -y

#EXPOSE 8000

################################
#    CONFIG LARAVEL DOCKER     #
################################

FROM php:7.4-apache

LABEL maintainer="Luis Ls"

RUN a2enmod rewrite

COPY . /var/www/html/

RUN apt-get update

RUN apt-get install nano -y

RUN apt-get install git -y

#RUN apt-get install zlibig-dev -y

RUN apt-get install libicu-dev -y

RUN apt-get install libxml2-dev -y

RUN apt-get install libpq -y

RUN apt-get install vim -y

WORKDIR /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 8000