#!/bin/sh

./bin/console doctrine:schema:update --force
cd app
./bin/console server:run 0.0.0.0:8000
