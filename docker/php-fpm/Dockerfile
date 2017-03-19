FROM phpdockerio/php71-fpm:latest

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install php-memcached php7.1-mysql php7.1-dev php-redis php7.1-bz2 php-pear libsasl2-dev pkg-config php-gearman \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


WORKDIR "/var/www/isp-monitor"

RUN     pecl update-channels

RUN 	pecl install mongodb

RUN echo "extension=mongodb.so" > /etc/php/7.1/fpm/conf.d/20-mongodb.ini && \
	echo "extension=mongodb.so" > /etc/php/7.1/cli/conf.d/20-mongodb.ini && \
	echo "extension=mongodb.so" > /etc/php/7.1/mods-available/mongodb.ini

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/lib/php/ -name xdebug.so)" > /etc/php/7.1/mods-available/xdebug.ini \
    && echo "xdebug.profiler_enable_trigger=on" >> /etc/php/7.1/mods-available/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /etc/php/7.1/mods-available/xdebug.ini
    && phpenmod xdebug