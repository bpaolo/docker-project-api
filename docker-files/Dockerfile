FROM ubuntu:xenial

RUN apt-get update
RUN apt-get -y dist-upgrade
RUN apt-get -y install python-software-properties
RUN apt-get -y install software-properties-common
RUN apt-get -y install locales
RUN apt-get -y install git

ENV OS_LOCALE="pt_BR.UTF-8"
RUN locale-gen ${OS_LOCALE}
ENV LANG=${OS_LOCALE} \
	LANGUAGE=en_US:en \
	LC_ALL=${OS_LOCALE} \
	NGINX_CONF_DIR=/etc/nginx

ENV PHP_RUN_DIR=/run/php \
    PHP_LOG_DIR=/var/log/php \
    PHP_CONF_DIR=/etc/php/7.1 \
    PHP_DATA_DIR=/var/lib/php

COPY ./supervisord.conf /etc/supervisor/conf.d/

# Install PHP libraries
RUN add-apt-repository -y ppa:ondrej/php 
RUN apt-get -y install wget
RUN \
	wget -O - https://nginx.org/keys/nginx_signing.key | apt-key add - \
	&& echo "deb http://nginx.org/packages/ubuntu/ xenial nginx" | tee -a /etc/apt/sources.list \
	&& echo "deb-src http://nginx.org/packages/ubuntu/ xenial nginx" | tee -a /etc/apt/sources.list \
	&& apt-get update
RUN apt-get install -y curl php7.1-fpm php7.1-cli php7.1-readline php7.1-mbstring php7.1-zip php7.1-intl php7.1-xml php7.1-json php7.1-curl php7.1-mcrypt php7.1-gd php7.1-pgsql php7.1-mysql php7.1-dev php-pear php-amqplib php-bcmath php7.1-soap php-memcached
RUN phpenmod mcrypt 

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --version=1.4.1 --install-dir=/usr/local/bin --filename=composer
RUN mkdir -p ${PHP_LOG_DIR} ${PHP_RUN_DIR}

RUN phpenmod mcrypt 
RUN apt-get install -y pkg-config

#install redis
RUN pecl install redis \
&&  rm -rf /tmp/pear

#install memcached
RUN apt-get install -y libfreetype6-dev libjpeg-dev libldap2-dev libmcrypt-dev libpng12-dev zlib1g-dev libpq-dev libpng-dev libmemcached-dev --no-install-recommends

#install xdebug
RUN pecl install xdebug

COPY ./configs-php/php-fpm.conf ${PHP_CONF_DIR}/fpm/php-fpm.conf
COPY ./configs-php/www.conf ${PHP_CONF_DIR}/fpm/pool.d/www.conf
COPY ./configs-php/php.ini ${PHP_CONF_DIR}/fpm/conf.d/custom.ini

# RUN git clone https://github.com/php-memcached-dev/php-memcached /usr/src/php/ext/memcached \
#  && cd /usr/src/php/ext/memcached && git checkout -b php7 origin/php7 \
#  && docker-php-ext-configure memcached \
#  && docker-php-ext-install memcached 

RUN sed -i "s~PHP_RUN_DIR~${PHP_RUN_DIR}~g" ${PHP_CONF_DIR}/fpm/php-fpm.conf \
    && sed -i "s~PHP_LOG_DIR~${PHP_LOG_DIR}~g" ${PHP_CONF_DIR}/fpm/php-fpm.conf \
    && chown www-data:www-data ${PHP_DATA_DIR} -Rf

#install nginx
RUN apt-get install -y nginx
RUN rm -rf  ${NGINX_CONF_DIR}/sites-enabled/* ${NGINX_CONF_DIR}/sites-available/* 

# Install supervisor
RUN apt-get install -y supervisor && mkdir -p /var/log/supervisor 

# Cleaning
RUN apt-get purge -y --auto-remove $buildDeps 
RUN apt-get autoremove -y && apt-get clean 
RUN rm -rf /var/lib/apt/lists/* 

COPY ./configs/nginx.conf ${NGINX_CONF_DIR}/nginx.conf
COPY ./configs/app.conf ${NGINX_CONF_DIR}/conf.d/default.conf
COPY ./configs/www.conf /etc/php/7.1/fpm/pool.d/www.conf

RUN mkdir /var/www
RUN mkdir /var/www/html
RUN chmod 777 -R /var/www/html

WORKDIR /var/www/html

CMD ["/usr/sbin/php-fpm7.1"]
CMD ["/usr/bin/supervisord"]
