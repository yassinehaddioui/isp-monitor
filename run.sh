#!/usr/bin/env bash

cd docker
docker-compose up -d
cd ..
composer install --ignore-platform-reqs
