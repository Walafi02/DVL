#!/bin/bash

clear

sudo apt-get install -y docker.io >> /dev/null && echo "Instalando Docker"

clear
echo "Baixando Imagens: 1 de 8"
sudo docker pull walafi02/dvl-seguranca-cliente
sudo docker tag 591320583f2537352f196c8295aa3b2c83f8a0a91ca2148ee8bccdfac5e430bc dvl-seguranca-cliente:1.0
sudo docker rmi walafi02/dvl-seguranca-cliente

clear
echo "Baixando Imagens: 2 de 8"
sudo docker pull walafi02/dvl-seguranca-servidor
sudo docker tag 88d7f10d6ce488de491d056f03aa727eb5edf2e4a83f19b986d929d13d4a2513 dvl-seguranca-servidor:1.0
sudo docker rmi walafi02/dvl-seguranca-servidor

clear
echo "Baixando Imagens: 3 de 8"
sudo docker pull walafi02/dvl-tcpip-cliente
sudo docker tag 8874008269472fc05a437516739b0274fee168f34b02bc869603e440a568f2b2 dvl-tcpip-cliente:1.0
sudo docker rmi walafi02/dvl-tcpip-cliente

clear
echo "Baixando Imagens: 4 de 8"
sudo docker pull walafi02/dvl-tcpip-servidor
sudo docker tag ecca252589f76c02708269c838e4f202245a27454d6b27a73af10150e5588ffd dvl-tcpip-servidor:1.0
sudo docker rmi walafi02/dvl-tcpip-servidor

clear
echo "Baixando Imagens: 5 de 8"
sudo docker pull walafi02/dvl-bd-cliente
sudo docker tag cd66278431a943816264e2ab7c66e92440c2de70802afb5e56c57dfba790acce dvl-bd-cliente:1.0
sudo docker rmi walafi02/dvl-bd-cliente

clear
echo "Baixando Imagens: 6 de 8"
sudo docker pull walafi02/dvl-bd-servidor
sudo docker tag cd66278431a943816264e2ab7c66e92440c2de70802afb5e56c57dfba790acce dvl-bd-servidor:1.0
sudo docker rmi walafi02/dvl-bd-servidor

clear
echo "Baixando Imagens: 7 de 8"
sudo docker pull walafi02/dvl-ubuntu-base
sudo docker tag 47247bb33fd56bbe9562ccae3254027306e39c6ff8c7ea6a15a0e2ee7b48be6a dvl-ubuntu-base:1.0
sudo docker rmi walafi02/dvl-ubuntu-base

clear
echo "Baixando Imagens: 8 de 8"
sudo docker pull walafi02/dvl-ubuntu-completo
sudo docker tag 2e3d6291161d04829af22035f3f67be08edf81f51925a2e13a59ab4117c31249 dvl-ubuntu-completo:1.0
sudo docker rmi walafi02/dvl-ubuntu-completo

clear
echo "Criando Redes"
sudo docker network create --driver bridge Rede_Alunos
sudo docker network create --driver bridge Rede1
sudo docker network create --driver bridge Rede2

clear
echo "Finalizado!"
