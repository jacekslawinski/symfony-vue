#!/bin/sh
echo "***********************************************"
echo "* STARTS: service apache2                     *"
service apache2 restart
echo "* RUNS: service apache2                       *"
echo "***********************************************"
cd /app
echo "* STARTS composer install                     *"
composer install
echo "* ENDS: composer install                      *"
echo "***********************************************"
echo "* STARTS: npm install                         *"
npm install
echo "*                DONE                         *"
echo "***********************************************"
echo "* STARTS: npm run build                        *"
npm run build
echo "*                DONE                         *"
echo "***********************************************"
tail -f /dev/null