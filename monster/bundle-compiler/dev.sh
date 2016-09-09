#!/bin/bash
npm i
npm run build -- --dev --bundlesPath=../../vendor/dotplant/monster/src/base-bundle/
npm run dev-server -- --dev --bundlesPath=../../vendor/dotplant/monster/src/base-bundle/
