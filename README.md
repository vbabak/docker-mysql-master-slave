Docker MySQL master-slave replication 
========================

MySQL 8.0 master-slave replication with using Docker. 

Previous version based on MySQL 5.7 is available in [mysql5.7](https://github.com/vbabak/docker-mysql-master-slave/tree/mysql5.7) branch.

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
