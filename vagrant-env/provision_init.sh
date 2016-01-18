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
chown vagrant:vagrant /vagrant/config/*-local.php


# restart nginx
service nginx restart

echo "==== Installing gulp ===="
npm install -g gulp
ln -s /usr/bin/nodejs /usr/local/bin/node

echo "==== Installing composer ===="

if [ -f $ENV_DIR/auth.json ]
then
    mkdir -p /home/vagrant/.composer
    cp $ENV_DIR/auth.json /home/vagrant/.composer/
    chown -R vagrant:vagrant /home/vagrant/.composer/
fi

composer self-update
su vagrant -c 'composer global require fxp/composer-asset-plugin ~1.1.1 --prefer-dist'

echo "==== Installing base dotplant3 ===="

cd /vagrant
su vagrant -c 'composer install --prefer-dist'
# run
su vagrant -c './yii migrate --interactive=0'

echo "==== DONE ===="
