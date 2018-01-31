#!/bin/bash

sudo echo "www-data ALL=NOPASSWD:   ALL" #>> /etc/sudors

sudo echo "
%alunos ALL=NOPASSWD: \
       	/usr/bin/docker exec -it * login" #>> /etc/sudors

cd ../..
sudo chown www-data.www-data -R DVL

cd DVL/users
sudo chmod 764 add.sh