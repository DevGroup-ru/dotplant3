#!/usr/bin/env bash
ENV_DIR="/vagrant/vagrant-env"
MYSQL_DATABASE="dotplant3"

echo "==== apt update ===="
apt-get update

echo "==== Installing dependencies ===="
apt-get install -y mc htop memcached nodejs npm

locale-gen ru_RU.UTF-8 en_US.UTF-8

echo "==== Creating database ===="
mysqladmin -uroot -pvagrant create $MYSQL_DATABASE

echo "==== Configuring web server ====="
cp $ENV_DIR/nginx/dotplant3.dev.conf /etc/nginx/conf.d/

# create local db config for running vagrant mysql db
echo "<?php
return [
    'dsn' => 'mysql:host=127.0.0.1;dbname=dotplant3',
    'username' => 'vagrant',
    'password' => 'vagrant',
];
" > /vagrant/config/db-local.php

echo "<?php
return [
    '192.168.33.1',
];
" > /vagrant/config/dev-ips-local.php

echo "<?php
return [
    'class' => 'yii\caching\MemCache',
    'useMemcached' => true,
];
" > /vagrant/config/cache-local.php

# restart nginx
service nginx restart

echo "==== Installing gulp ===="
npm install -g gulp
ln -s /usr/bin/nodejs /usr/local/bin/node

echo "==== Installing composer ===="
cd /root
curl -sS https://getcomposer.org/installer | /usr/local/php7/bin/php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer

echo "==== Installing base dotplant3 ===="

cd /vagrant
composer install --prefer-dist
# run
./yii migrate --interactive=0

echo "==== DONE ===="
