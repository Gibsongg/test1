#!/bin/bash 

cd ./lara
docker-compose up -d --build
docker-compose exec -T workspace bash -c "cd app/api && composer install --verbose --prefer-dist --no-progress --no-interaction --no-dev --optimize-autoloader"