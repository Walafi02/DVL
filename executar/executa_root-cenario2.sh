#!/bin/bash

clear
ip=2
docker network create --driver bridge Rede_Alunos &> /dev/null

function ScriptConecta {
    sudo touch /home/$1/$2.sh
	sudo chown www-data:www-data /home/$1/$2.sh
	sudo chmod 705 /home/$1/$2.sh

	echo "#!/bin/bash" > /home/$1/$2.sh
	echo "clear" >> /home/$1/$2.sh
	echo "sudo docker exec -it $3 login" >> /home/$1/$2.sh
#	echo "sudo docker attach $3" >> /home/$1/$2.sh
}

Gateway=$1-$2-$3-"Gateway"
Maquina01=$1-$2-$4-"Maquina01"
Maquina02=$1-$2-$5-"Maquina02"

##Maquina Gateway##
sudo docker run --privileged -itd -h $Gateway --name $Gateway dvl-ubuntu-completo:1.0 /bin/bash

sudo docker network connect Rede_Alunos $Gateway

sudo docker exec $Gateway ifconfig eth1 0


##maquina 01##
sudo docker run --privileged -itd -h $Maquina01 --name $Maquina01 --net Rede_Alunos dvl-ubuntu-completo:1.0 /bin/bash
sudo docker exec $Maquina01 ifconfig eth0 0


##maquina 02##
sudo docker run --privileged -itd -h $Maquina02 --name $Maquina02 --net Rede_Alunos dvl-ubuntu-completo:1.0 /bin/bash
sudo docker exec $Maquina02 ifconfig eth0 0

ScriptConecta $2 Conecta$Gateway $Gateway
ScriptConecta $2 Conecta$Maquina01 $Maquina01
ScriptConecta $2 Conecta$Maquina02 $Maquina02

