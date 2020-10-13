FROM php:7.4-fpm
COPY wait-for-it.sh /usr/bin/wait-for-it
RUN chmod +x /usr/bin/wait-for-it
RUN apt-get update && apt-get install -y git libpq-dev zlib1g-dev libxml2-dev librabbitmq-dev libzip-dev libonig-dev
RUN docker-php-ext-install zip 
RUN pecl install amqp 
RUN docker-php-ext-enable amqp # Enable the Extension 
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo_pgsql
#COPY --from=composer /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
#CMD composer install ; wait-for-it database:5432 -- bin/console doctrine:migrations:migrate ;  php-fpm 
# CMD wait-for-it postgres:5432 && bin/console doctrine:migrations:migrate ;  php-fpm 
CMD bin/console doctrine:migrations:migrate ;  php-fpm 
EXPOSE 9000