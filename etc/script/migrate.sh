#!/usr/bin/env bash

echo "----------------------------------------"
echo "++++++++++++ UPDATE PROJECT ++++++++++++"

PROJECT_NAME=asset

if [ -z ${ENV} ];then
    ENV="dev"
fi

if [ -z ${S3VAR_PATH} ];then
    S3VAR_PATH="$HOME/.zuragan_config/zuragan.$ENV.env"
fi

if [ ! -f ${S3VAR_PATH} ] ; then
    echo "S3 VARIABLE PATH not found, we can not generate requiring file"
fi

echo ">> fetch env file"
env $(sh ${S3VAR_PATH} ${PROJECT_NAME} | xargs) ./etc/script/zuget.sh ${PWD}

echo ">> install dependency"
docker-compose exec hhvm ./composer.phar install

echo ">> install migration"
docker-compose exec hhvm php artisan migrate