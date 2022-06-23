#!/bin/sh

sleep 15

cd /app
# set up database
php bin/console doctrine:database:create --if-not-exists -n
php bin/console doctrine:migrations:migrate -n

# run worker
php bin/console messenger:consume async &

# run server

symfony server:start
