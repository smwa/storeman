#!/bin/bash
docker stop sm
docker rm sm
docker run -d --name sm -p 80:80 -v `pwd`/build:/app:ro -v `pwd`/sql:/sql:ro --link smdb:db tutum/apache-php
