#!/bin/bash
set -e

# Get script directory
DIR=$(dirname $(readlink -f "$0"))

##
# Install composer packages
# Don't install require-dev packages if this isn't development environment
##
if [ "$WP_ENV" = "" ] || [ "$WP_ENV" = "development" ]; then

  # Install all composer packages
  echo "Installing composer packages..."
  composer install --working-dir=$DIR/../

elif [ "$WP_ENV" = "testing" ]; then

  # You can install PHP QA tools here like:
  # https://github.com/sebastianbergmann/phpcpd/

  # Install same packages as in production
  # It's important to use same composer config here as in production
  echo "Installing composer packages..."
  composer install --no-interaction --no-dev --working-dir=$DIR/../

else

  # Install composer dependencies without require-dev
  echo "Installing composer packages without dev..."
  composer install --no-interaction --no-dev --working-dir=$DIR/../

fi

