FROM ubuntu:16.04

RUN apt-get -y update && apt-get install -y php7.0-fpm php7.0-cli php7.0-curl php7.0-gd php7.0-intl php7.0-zip php7.0-pgsql build-essential git gcc make re2c libpcre3-dev php7.0-dev curl

RUN curl -sS http://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

RUN composer global require "phalcon/zephir:dev-master"

RUN mkdir -p /opt/www
RUN cd /opt && git clone http://github.com/phalcon/cphalcon -b 2.1.x --single-branch
RUN cd /opt/cphalcon && ~/.composer/vendor/bin/zephir build --backend=ZendEngine3; exit 0

RUN echo "extension=phalcon.so" >> /etc/php/7.0/fpm/conf.d/20-phalcon.ini
RUN sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/g" /etc/php/7.0/cli/php.ini
RUN sed -i "s/memory_limit = 128M/memory_limit = 256M /g" /etc/php/7.0/fpm/php.ini

RUN service php7.0-fpm restart

CMD cd /opt/www && php -S 0.0.0.0:80