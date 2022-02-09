#!/usr/bin/env bash
export XDEBUG_CONFIG="idekey=IDEA_DEBUG_ASSET"
DB_HOST=127.0.0.1 DB_PORT=25434 php artisan serv --port=9494
