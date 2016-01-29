#!/bin/bash

PACKAGES='yii2-admin-utils
yii2-multilingual
yii2-polyglot
yii2-deferred-tasks
yii2-intent-analytics
yii2-data-structure-tools
yii2-frontend-utils
yii2-extensions-manager
yii2-users-module'

$CURDIR=`pwd`

for Package in $PACKAGES
do
    cd ../../../$Package
    git pull
done

cd $CURDIR

for Package in $PACKAGES
do
    rm -rf vendor/devgroup/$Package
done

composer update

for Package in $PACKAGES
do
    rm -rf vendor/devgroup/$Package
    ln -s ../../../$Package vendor/devgroup/
done

rm -rf vendor/bower/frontend-monster
rm -rf vendor/devgroup/bh
ln -s ../../../frontend-monster vendor/bower/
ln -s ../../../bh-php vendor/devgroup/bh
chmod +r vendor/bower/frontend-monster/dist/*/*
ls -la vendor/devgroup