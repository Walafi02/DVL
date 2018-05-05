#!/bin/bash

sudo echo "www-data        ALL=NOPASSWD: ALL" >> /etc/sudoers

sudo echo "%alunos		ALL=NOPASSWD:\\
			/usr/bin/docker exec -it * login" >> /etc/sudoers

mkdir ../executar
mkdir ../matriculas

cd ../users
sudo chmod 764 add.sh

cd ../..
sudo chown www-data.www-data -R DVL
