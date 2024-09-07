FROM php:8.3-fpm-alpine

ENV USER=appuser
ENV GROUPNAME=$USER
ENV UID=12345
ENV GID=23456

RUN addgroup \
    --gid "$GID" \
    "$GROUPNAME" \
&&  adduser \
    --disabled-password \
    --gecos "" \
    --home "$(pwd)" \
    --ingroup "$GROUPNAME" \
    --no-create-home \
    --uid "$UID" \
    $USER

# Install system dependencies
RUN apk add --no-cache \
    nodejs \
    npm \
    caddy \
    git && \
    # Install PHP extensions
    docker-php-ext-install pdo pdo_mysql exif && \
    docker-php-ext-enable exif && \
    # Install Composer
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./ci/entrypoint.sh /etc/entrypoint.sh
RUN chmod +x /etc/entrypoint.sh

# Set working directory
WORKDIR /var/www/html

# Copy Laravel project files
COPY --chown=appuser:appuser .. .

# Switch user
USER appuser

# Install Composer dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Install NPM dependencies and build assets
RUN npm install && npm run build

# Set permissions
RUN chown -R appuser:appuser storage bootstrap/cache

# Expose port 80
EXPOSE 80

ENTRYPOINT ["sh", "/etc/entrypoint.sh"]
