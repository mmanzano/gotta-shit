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
    yum-config-manager --enable  remi-php71 && \
	yum -y install \
           php71-php-fpm \
           php71-php-json \
           php71-php-xml \
           php71-php-mysqli \
           php71-php-mbstring \
           php71-php-mysqlnd \
           php71-php-gd \
           php71-php-ldap \
           php71-php-mcrypt \
           php71-php-pecl-zip \
           php71-php-soap \
           php71-php-intl \
           php71-php \
           php71-php-pdo \
           php71-php-pecl-imagick \
           nano


RUN mkdir -p /var/log/php-fpm
RUN ln -s /opt/remi/php71/root/sbin/php-fpm /usr/sbin/php-fpm
RUN ln -s /usr/bin/php71 /usr/bin/php
RUN ln -sf /dev/stderr /var/log/php-fpm/error.log

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=. --filename=composer \
    && mv composer /usr/local/bin/

COPY docker/php/www.conf /etc/opt/remi/php71/php-fpm.d/www.conf
CMD ["php-fpm", "-F"]