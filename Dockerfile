FROM php:8.0-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y

RUN echo 'LogFormat "%h %l %u %t \"%r\" %>s %O \"%{Referer}i\" \"%{User-Agent}i\" %{ms}T %p %{Host}i" vhost_combined' >> /etc/apache2/apache2.conf

COPY ./src /var/www/html
