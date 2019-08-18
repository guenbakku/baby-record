FROM php:7.2-apache

LABEL author="guenbakku"

# Install zip & git (Required for composer install)
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        git\
        zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy private key
COPY ./ec2-virginia-ec2-user.pem /root/.ssh/private_keys/ec2-virginia-ec2-user.pem
RUN chmod 400 /root/.ssh/private_keys/ec2-virginia-ec2-user.pem
