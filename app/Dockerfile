# syntax=docker/dockerfile:1.4

FROM --platform=$BUILDPLATFORM php:8.2-apache as builder

RUN apt update
RUN apt install -yq git

# Install composer (https://getcomposer.org/download/)
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /bin/composer



# Install Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash
RUN mv /root/.symfony5/bin/symfony /bin/symfony


# Disable Apache default site
RUN a2dissite 000-default.conf

COPY etc/apache-site.conf /etc/apache2/sites-available/apache-site.conf
RUN a2ensite apache-site.conf

# Install dependency
RUN docker-php-ext-install pdo_mysql