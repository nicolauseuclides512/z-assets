#!/usr/bin/env bash

CUR_DIR=${PWD}
PROJECT_NAME=asset

if [ -z $ENV ];then
    ENV="dev"
fi

if [ -z ${S3VAR_PATH} ];then
    S3VAR_PATH="$HOME/.zuragan_config/zuragan.$ENV.env"
fi

echo "-------------------------------------------------"
echo ">>    STARTING ZURAGAN ASSET [== $ENV ==]      <<"
echo "-------------------------------------------------"

#check dependency
for p in docker docker-compose java; do
    if ! hash "$p" &>/dev/null; then
        echo "$p is required dependency. please install first."
        exit
    fi
done

#check existence oauth file, if exist remove it
if [ -f ./storage/oauth-private* ]; then
    rm ./storage/oaut*
fi

#check existence storage, if not exist create it
if [ ! -d ./storage ]; then
    mkdir ./storage
fi

#check path of s3var
if [ ! -f ${S3VAR_PATH} ] ; then
    echo "S3 VARIABLE PATH not found, we can not generate requiring file"
fi

#download environment variable
printf "\n--------Download environment variable--------\n"
env $(sh ${S3VAR_PATH} ${PROJECT_NAME} | xargs) ./etc/script/zuget.sh ${PWD}
echo "--------environment downloaded--------"

#set default docker-compose file
DC="-f docker-compose.yml"

#set when env development
if [ ${ENV} == "dev" ];then
    DC="-f dc-local.yml"

    while [ -z "$IP_ANSWER" ]; do
       printf "\nEnter your local ip address (e.g: 192.168.1.1) : \n"
       read IP_ANSWER
    done

    export MY_IP_ADDR=${IP_ANSWER}

    export XDEBUG_IDEKEY="zuragan-asset-server"

    sed -i -e "s/192.168.1.2/$IP_ANSWER/g" ./.env

    if [ -f ./.env-e ]; then
        rm ./.env-e
    fi

    printf "\nYour Ip Address: $IP_ANSWER \nYour Debug Idea Key: $XDEBUG_IDEKEY\n"
fi

#reset confirmation
printf "\nDo you wish to reset before start service? (y/N/c)? "
read answer
if echo "$answer" | grep -iq "^y" ;then
    docker-compose down
elif echo "$answer" | grep -iq "^c" ;then
    exit
fi

#build container
docker-compose $DC build

#running composer
echo "Install App Dependency"
docker run --rm -v $(pwd):/var/www -w /var/www sahitoassets_fpm php ./composer.phar install

echo "-------------------------------------------------"
echo "+++++++++++++++ START APP CONTAINER +++++++++++++"
docker-compose $DC up -d --remove-orphans db fpm web filebeat

sleep 10

#DB migrate
docker-compose exec fpm php artisan migrate

#running seeder
case $@ in
    -i|--install)
        docker-compose exec fpm php artisan db:seed

        #check existence symlink
        if [ ! -L ./public/storage ]; then
            docker-compose exec fpm php artisan storage:link
        fi
    ;;
    *)
esac

#show docker log
docker-compose logs -f