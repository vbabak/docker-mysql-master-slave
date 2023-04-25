#!/bin/sh

#while ! nc -z mysql_master 3306; do echo 'waiting for master...' && sleep 1; done
#while ! nc -z mysql_slave 3306; do echo 'waiting for slave...' && sleep 1; done

#./bin/console doctrine:schema:update --force
cd app
./bin/console server:run 0.0.0.0:8000
