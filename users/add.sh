#!/bin/bash

addgroup alunos

sudo useradd $1 -g alunos -s /bin/bash -m
sudo echo $1:$1 > senhas.txt
sudo chpasswd < senhas.txt
sudo passwd -e $1 >> /dev/null

sudo rm senhas.txt
