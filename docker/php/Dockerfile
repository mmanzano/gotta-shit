FROM centos:7
EXPOSE 9000
WORKDIR /var/www/web

RUN \
    yum -y update wget yum-utils&& \
	yum -y install deltarpm && \
	yum -y install epel-release && \
	rpm --import http://rpms.famillecollet.com/RPM-GPG-KEY-remi && \
    rpm -ivh http://rpms.famillecollet.com/enterprise/remi-release-7.rpm
RUN yum-config-manager --enable extras && \
	yum-config-manager --enable epel && \
	yum-config-manager --enable remi && \
	yum-config-manager --disable remi-php55 && \
	yum-config-manager --disable remi-php56 && \
	yum-config-manager --disable remi-php70 && \
    yum-config-manager --disable remi-php71 && \
    yum-config-manager --disable remi-php73 && \
    yum-config-manager --disable remi-php74 && \
    yum-config-manager --enable  remi-php74 && \
	yum -y install \
           php74-php-fpm \
           php74-php-json \
           php74-php-xml \
           php74-php-mysqli \
           php74-php-mbstring \
           php74-php-mysqlnd \
           php74-php-gd \
           php74-php-ldap \
           php74-php-mcrypt \
           php74-php-pecl-zip \
           php74-php-soap \
           php74-php-intl \
           php74-php \
           php74-php-pdo \
           php74-php-pecl-imagick \
           php-pecl-xdebug \
           nano


RUN mkdir -p /var/log/php-fpm
RUN ln -s /opt/remi/php74/root/sbin/php-fpm /usr/sbin/php-fpm
RUN ln -s /usr/bin/php74 /usr/bin/php
RUN ln -sf /dev/stderr /var/log/php-fpm/error.log

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=. --filename=composer \
    && mv composer /usr/local/bin/

COPY docker/php/www.conf /etc/opt/remi/php74/php-fpm.d/www.conf
CMD ["php-fpm", "-F"]