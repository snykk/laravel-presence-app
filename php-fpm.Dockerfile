FROM suitmedia/base-php-fpm:8.0.11

# Install mysql-client
RUN apk add mysql-client

# RUN docker-php-ext-install opcache

# Update composer
RUN composer self-update --2

# Setup log directory
RUN mkdir -p /usr/local/var/log/php-fpm
RUN touch /usr/local/var/log/php-fpm/laravel.log /usr/local/var/log/php-fpm/php-fpm.log
RUN chmod 0777 /usr/local/var/log/php-fpm
RUN chmod 0666 /usr/local/var/log/php-fpm/*.log

# Argument setup
ARG LARAVEL_ENV
ARG SPATIE_USERNAME
ARG SPATIE_PASSWORD
ENV LARAVEL_ENV=${LARAVEL_ENV}
ENV SPATIE_USERNAME=${SPATIE_USERNAME}
ENV SPATIE_PASSWORD=${SPATIE_PASSWORD}

# Copy source
RUN mkdir -p /var/www/gopay-backend
COPY . /var/www/gopay-backend/

# Setup log
RUN rm -fr /var/www/gopay-backend/storage/logs
RUN chown -R www-data:www-data /usr/local/var/log/php-fpm
RUN ln -s /usr/local/var/log/php-fpm /var/www/gopay-backend/storage/logs

# Set application configuration file
RUN echo $LARAVEL_ENV > /var/www/gopay-backend/.env-encoded
RUN base64 -d /var/www/gopay-backend/.env-encoded > /var/www/gopay-backend/.env

# Install application
RUN rm -fr /var/www/gopay-backend/vendor
RUN cd /var/www/gopay-backend/ && composer config --unset repositories.1
RUN cd /var/www/gopay-backend/ && composer config --unset repositories.2
RUN cd /var/www/gopay-backend/ && composer remove "richan-fongdasen/laravel-api-generator" --dev --no-update
RUN cd /var/www/gopay-backend/ && composer remove "richan-fongdasen/laravel-cms-generator" --dev --no-update
RUN cd /var/www/gopay-backend/ && composer config --global "http-basic.satis.spatie.be" ${SPATIE_USERNAME} ${SPATIE_PASSWORD}
RUN cd /var/www/gopay-backend/ && composer install --optimize-autoloader --no-dev
RUN php /var/www/gopay-backend/artisan clear-compiled
RUN php /var/www/gopay-backend/artisan optimize
RUN php /var/www/gopay-backend/artisan storage:link
RUN php /var/www/gopay-backend/artisan horizon:publish
RUN rm -fr /var/www/gopay-backend/.docker
RUN chown -R www-data:www-data /var/www/gopay-backend/
RUN chmod -R 777 /var/www/gopay-backend/storage/

#
# Enable Laravel Horizon
#
# RUN php /var/www/gopay-backend/artisan config:clear
# RUN php /var/www/gopay-backend/artisan route:clear
# RUN sed -i 's/TELESCOPE_ENABLED=false/TELESCOPE_ENABLED=true/' /var/www/gopay-backend/.env
# RUN sed -i 's/TELESCOPE_QUERY_WATCHER=false/TELESCOPE_QUERY_WATCHER=true/' /var/www/gopay-backend/.env

#
#--------------------------------------------------------------------------
# PHP-FPM
#--------------------------------------------------------------------------
#

COPY .docker/php-fpm/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY .docker/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY .docker/php-fpm/php.ini /usr/local/etc/php/php.ini
COPY .docker/php-fpm/docker-php-ext-opcache.ini /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini

WORKDIR /var/www/gopay-backend

# RUN php artisan scribe:generate

CMD ["php-fpm"]

EXPOSE 9000
