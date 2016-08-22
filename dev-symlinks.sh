#!/bin/bash

DEVGROUP_PACKAGES='yii2-admin-utils
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
yii2-media-storage
yii2-measure
yii2-users-module'
CURRENT_DIRECTORY=`pwd`

for Package in ${DEVGROUP_PACKAGES}
do
    cd ../${Package}
    echo "Updating git $Package"
    git pull
done

cd ${CURRENT_DIRECTORY}

for Package in ${DEVGROUP_PACKAGES}
do
    rm -rf vendor/devgroup/${Package}
done

composer update -vvv

for Package in ${DEVGROUP_PACKAGES}
do
    rm -rf vendor/devgroup/${Package}
    ln -s ../../../${Package} vendor/devgroup/
done

rm -rf vendor/devgroup/bh
ln -s ../../../bh-php vendor/devgroup/bh

rm -rf vendor/dotplant/monster
ln -s ../../../monster vendor/dotplant/monster

rm -rf vendor/dotplant/content
ln -s ../../../dotplant-content vendor/dotplant/content

rm -rf vendor/dotplant/entity-structure
ln -s ../../../dotplant-entity-structure vendor/dotplant/entity-structure

ls -la vendor/devgroup

./yii extension/update-config

EXTENSIONS='dotplant/content
dotplant/entity-structure
dotplant/monster
devgroup/yii2-admin-utils
devgroup/yii2-data-structure-tools
devgroup/yii2-deferred-tasks
devgroup/yii2-entity
devgroup/yii2-events-system
devgroup/yii2-extensions-manager
devgroup/yii2-frontend-utils
devgroup/yii2-intent-analytics
devgroup/yii2-jsoneditor
devgroup/yii2-jstree-widget
devgroup/yii2-measure
devgroup/yii2-media-storage
devgroup/yii2-multilingual
devgroup/yii2-polyglot
devgroup/yii2-tag-dependency-helper
devgroup/yii2-users-module'

for Ext in ${EXTENSIONS}
do
    ./yii extension/activate ${Ext}
done

./yii migrate