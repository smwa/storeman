#!/bin/bash
docker stop smdb
docker rm smdb
docker run -d --name smdb -e MYSQL_ROOT_PASSWORD="password" -v `pwd`/db:/var/lib/mysql mysql
