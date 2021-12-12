# Fixed PHP image
FROM php:8.1.0-cli

# Common labels
LABEL maintainer="Murilo Chianfa <github.com/murilochianfa>"
LABEL br.com.redstore.version="0.0.1-beta"
LABEL br.com.redstore.version.is-production="no"
LABEL br.com.redstore.release-date="2021-12-12"
LABEL vendor="Realtime-server-stats"

# Expose default HTTP port
EXPOSE 80

# Set default workdir to user
WORKDIR /app

# Init server on port 80
CMD php -S 0.0.0.0:80

