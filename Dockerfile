# base image
FROM php:8.1-rc-apache
RUN docker-php-ext-install mysqli

# Install python
RUN apt-get update -y && apt-get upgrade -y

RUN apt-get install -y apt-utils && apt-get install -y python3