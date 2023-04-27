Symfony Doctrine Docker MySQL master-slave replication 
========================

A simple Symfony app that uses a primary database for writes and a replica database for reads.
MySQL 8.0 master-slave replication with using Docker. 

See the code in Doctrine DBAL [here](https://github.com/doctrine/dbal/blob/master/lib/Doctrine/DBAL/Connections/MasterSlaveConnection.php).

Forked from [vbabak](https://github.com/vbabak/docker-mysql-master-slave)
Previous version based on MySQL 5.7 is available in [mysql5.7](https://github.com/vbabak/docker-mysql-master-slave/tree/mysql5.7) branch.
Mixed with code from [backbeat-tech](https://github.com/backbeat-tech/doctrine-mysql-replica-demo.git)

## Run

To run this examples you will need to start containers with "docker-compose" 
and after starting setup replication. See commands inside ./build.sh. 

#### Create 2 MySQL containers with master-slave row-based replication 

```bash
./build.sh
```

#### Make changes to master

```bash
docker exec mysql_master sh -c "export MYSQL_PWD=111; mysql -u root mydb -e 'create table code(code int); insert into code values (100), (200)'"
```

#### Read changes from slave

```bash
docker exec mysql_slave sh -c "export MYSQL_PWD=111; mysql -u root mydb -e 'select * from code \G'"
```

## Troubleshooting

#### Check Logs

```bash
docker-compose logs
```

#### Start containers in "normal" mode

> Go through "build.sh" and run command step-by-step.

#### Check running containers

```bash
docker-compose ps
```

#### Clean data dir

```bash
rm -rf ./master/data/*
rm -rf ./slave/data/*
```

#### Run command inside "mysql_master"

```bash
docker exec mysql_master sh -c 'mysql -u root -p111 -e "SHOW MASTER STATUS \G"'
```

#### Run command inside "mysql_slave"

```bash
docker exec mysql_slave sh -c 'mysql -u root -p111 -e "SHOW SLAVE STATUS \G"'
```

#### Enter into "mysql_master"

```bash
docker exec -it mysql_master bash
```

#### Enter into "mysql_slave"

```bash
docker exec -it mysql_slave bash
```

## URLs

* http://localhost:8001/ - select query, uses replica only
* http://localhost:8001/insert - insert query, uses primary only
* http://localhost:8001/update/{id} - select and update queries, uses replica to fetch the data then switches to primary
* http://localhost:8001/ping - troubleshooting, no database used

## Observing logs

The app logs are available in the docker-compose output (run `docker-compose logs -f app`), showing which database is being used:

```
app_1      | 2019-03-27T17:17:39+00:00 [info] Matched route "app_app_update".
app_1      | 2019-03-27T17:17:40+00:00 [debug] SELECT t0.id AS id_1, t0.level AS level_2, t0.hash AS hash_3 FROM item t0 WHERE t0.id = ?
app_1      | 2019-03-27T17:17:40+00:00 [debug] Used REPLICA for the previous query.
app_1      | 2019-03-27T17:17:40+00:00 [debug] "START TRANSACTION"
app_1      | 2019-03-27T17:17:40+00:00 [debug] UPDATE item SET level = ?, hash = ? WHERE id = ?
app_1      | 2019-03-27T17:17:40+00:00 [debug] "COMMIT"
app_1      | 2019-03-27T17:17:40+00:00 [debug] Used PRIMARY for the previous query.
app_1      | [Wed Mar 27 17:17:40 2019] 172.19.0.1:60352 [200]: /update/1
```
