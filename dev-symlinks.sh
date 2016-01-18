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
ln -s ../../../frontend-monster vendor/bower/
chmod +r vendor/bower/frontend-monster/dist/*/*
ls -la vendor/devgroup