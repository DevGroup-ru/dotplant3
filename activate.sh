#!/usr/bin/env bash
./yii extension/activate devgroup/yii2-users-module
./yii extension/activate devgroup/yii2-entity
./yii extension/activate devgroup/yii2-events-system
./yii extension/activate devgroup/yii2-extensions-manager
./yii extension/activate dotplant/monster
sleep 5
./yii extension/activate dotplant/entity-structure
sleep 5
./yii extension/activate dotplant/content
