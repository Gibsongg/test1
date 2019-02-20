#!/bin/bash 

cd ./lara
service mysql stop
docker-compose up -d
