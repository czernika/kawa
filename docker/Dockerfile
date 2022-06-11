FROM nanoninja/php-fpm:8.0

WORKDIR /var/www/html

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install wp-cli
RUN apt-get update && apt-get install -y sudo less mariadb-client

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
RUN chmod +x wp-cli.phar && mv wp-cli.phar /usr/local/bin/wp

RUN mkdir -p /var/www/.wp-cli/cache
RUN chown www-data:www-data -R /var/www/.wp-cli

# Install NodeJS
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs

# Forward Message to mailhog
RUN curl --location --output /usr/local/bin/mhsendmail https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 && \
    chmod +x /usr/local/bin/mhsendmail
RUN echo 'sendmail_path="/usr/local/bin/mhsendmail --smtp-addr=mailhog:1025 --from=no-reply@gbp.lo"' > /usr/local/etc/php/conf.d/mailhog.ini

# Allow to upload files https://github.com/docker-library/wordpress/issues/162#issuecomment-233656954
RUN usermod -u 1000 www-data

# Note: Use `docker compose up -d --force-recreate --build` when Dockerfile has changed.