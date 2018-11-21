#!/bin/bash
./composer install
./app/console doctrine:database:drop --force
./app/console doctrine:database:create
./app/console doctrine:schema:update --force
./app/console cache:clear