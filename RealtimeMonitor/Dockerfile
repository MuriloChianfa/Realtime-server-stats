# Fixed PHP image
FROM php:8.1.0-cli

# Common labels
LABEL maintainer="Murilo Chianfa <github.com/murilochianfa>"
LABEL br.com.redstore.version="0.0.1-beta"
LABEL br.com.redstore.version.is-production="no"
LABEL br.com.redstore.release-date="2021-12-12"
LABEL vendor="Realtime-server-stats"

# Default WebSocket application port
EXPOSE 9501

# Install all PHP dependencies
RUN apt-get update && \
    apt-get -o Acquire::ForceIPv4=true -y \
    --allow-unauthenticated install \
    libcurl4-openssl-dev \
    libssl-dev \
    libcurl4 \
    openssl \
    procps \
    wget \
    curl \
    git \
    htop \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Compile PHP with swoole extenstion
RUN cd /tmp && git clone https://github.com/openswoole/swoole-src.git && \
    cd swoole-src && \
    git checkout v4.8.1 && \
    phpize  && \
    ./configure --enable-openssl --enable-swoole-curl --enable-http2 --enable-mysqlnd && \
    make && make install

# Enable swoole extension
RUN touch /usr/local/etc/php/conf.d/openswoole.ini && \
    echo 'extension=openswoole.so' > /usr/local/etc/php/conf.d/zzz_openswoole.ini

# Add composer to install all dependencies
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Generation dump-init to PHP server
RUN wget -O /usr/local/bin/dumb-init https://github.com/Yelp/dumb-init/releases/download/v1.2.2/dumb-init_1.2.2_amd64
RUN chmod +x /usr/local/bin/dumb-init
RUN mkdir -p /data/log/ && touch /data/log/swoole-task.log && chmod 777 /data/log/swoole-task.log

# Set default workdir
WORKDIR /app/

# Run dump-init on startup
ENTRYPOINT ["php", "server.php"]

