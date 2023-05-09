FROM suitmedia/base-laravel-horizon:8.0.11

# RUN docker-php-ext-install opcache

# Update composer
RUN composer self-update --2

# Setup log directory
RUN mkdir -p /var/log/horizon
RUN touch /var/log/horizon/horizon.log /var/log/horizon/laravel.log
RUN chmod 0777 /var/log/horizon
RUN chmod 0666 /var/log/horizon/*.log

# Argument setup
ARG LARAVEL_ENV
ARG SPATIE_USERNAME
ARG SPATIE_PASSWORD
ENV LARAVEL_ENV=${LARAVEL_ENV}
ENV SPATIE_USERNAME=${SPATIE_USERNAME}
ENV SPATIE_PASSWORD=${SPATIE_PASSWORD}

# Copy application sources
RUN mkdir /var/www/gopay-backend
COPY . /var/www/gopay-backend/

# Log setup
RUN rm -fr /var/www/gopay-backend/storage/logs
RUN chown -R horizon:horizon /var/log/horizon
RUN ln -s /var/log/horizon /var/www/gopay-backend/storage/logs

# Application configuration setup
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
RUN chown -R horizon:horizon /var/www/gopay-backend/
RUN chmod -R 777 /var/www/gopay-backend/storage/

#
#--------------------------------------------------------------------------
# Optional Supervisord Configuration
#--------------------------------------------------------------------------
#
# Modify the ./supervisor.conf file to match your App's requirements.
# Make sure you rebuild your container with every change.
#

RUN mkdir /etc/supervisord.d
COPY .docker/laravel-horizon/supervisord.d/* /etc/supervisord.d/
COPY .docker/laravel-horizon/supervisord.conf /etc/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]

#
#--------------------------------------------------------------------------
# Optional Software's Installation
#--------------------------------------------------------------------------
#
# If you need to modify this image, feel free to do it right here.
#
# -- Your awesome modifications go here -- #

#
#--------------------------------------------------------------------------
# Check PHP version
#--------------------------------------------------------------------------
#

RUN php -v | head -n 1 | grep -q "PHP ${PHP_VERSION}."

#
#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------
#

WORKDIR /etc/supervisor/conf.d/
