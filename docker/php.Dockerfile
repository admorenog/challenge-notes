FROM php:8-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql

#removing the annoying error bell in shell and xdebug error message for not connecting.
RUN echo "set bell-style visible" > ~/.inputrc \
	&& touch /var/log/php_error.log && chmod og+w /var/log/php_error.log

RUN apt update \
	&& apt -y upgrade \
	&& apt -y install vim git zip zsh sudo

# PHP config
RUN pecl install xdebug

# Apache configuration
RUN a2enmod rewrite \
	&& echo "ServerName 127.0.0.1" >> /etc/apache2/apache2.conf \
	&& sed -i 's/\/var\/www\/html/\/var\/www\/html\/public/g' /etc/apache2/sites-enabled/000-default.conf

# Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
	&& php -r "if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
	&& php composer-setup.php \
	&& php -r "unlink('composer-setup.php');" \
	&& mv composer.phar /usr/local/bin/composer

# Permissions
RUN groupadd -g 1000 app \
	&& useradd app -g app -u 1000 -m \
	&& chown -R app:app /var/www

RUN echo "set bell-style visible" > /home/app/.inputrc

# node 16
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.1/install.sh | sudo -u app bash
RUN echo 'export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")"' >> /home/app/.zshrc && \
   echo '[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" # This loads nvm' >> /home/app/.zshrc && \
   chown app:app /home/app/.zshrc

WORKDIR /var/www/html
