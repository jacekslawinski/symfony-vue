#!/bin/bash
if [ -z "$1" ]; then
    APP_ENV=test bin/console d:m:m --no-interaction && vendor/bin/phpunit -c phpunit.xml
else
    vendor/bin/phpunit -c phpunit.xml --group $1
fi

