#!/bin/bash

PACKAGES='yii2-admin-utils
yii2-multilingual
yii2-polyglot
yii2-deferred-tasks
yii2-intent-analytics
yii2-data-structure-tools
yii2-frontend-utils
yii2-extensions-manager
yii2-tag-dependency-helper
yii2-entity
yii2-events-system
yii2-jsoneditor
yii2-measure
yii2-users-module'

CURRENT_DIRECTORY=`pwd`

for Package in ${PACKAGES}
do
    cd ../${Package}
    echo "Updating git $Package"
    git pull

done

cd ${CURRENT_DIRECTORY}

for Package in ${PACKAGES}
do
    rm -rf vendor/devgroup/${Package}
done

composer update

for Package in ${PACKAGES}
do
    rm -rf vendor/devgroup/${Package}
    ln -s ../../../${Package} vendor/devgroup/
done

rm -rf vendor/devgroup/bh
ln -s ../../../bh-php vendor/devgroup/bh
rm -rf vendor/dotplant/monster
ln -s ../../../monster vendor/dotplant/monster
ls -la vendor/devgroup
