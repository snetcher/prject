FROM wordpress:latest

# Install dependencies
RUN apt-get update && apt-get install -y \
    curl \
    less \
    && rm -rf /var/lib/apt/lists/*

# Install WP-CLI
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp

# Verify WP-CLI installation
RUN wp --info

# Remove Akismet and Hello Dolly plugins
RUN rm -rf /usr/src/wordpress/wp-content/plugins/akismet \
    && rm -rf /usr/src/wordpress/wp-content/plugins/hello.php

# Set working directory
WORKDIR /var/www/html