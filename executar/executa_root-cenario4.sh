#!/bin/bash

clear

function ScriptConecta {
	sudo touch /home/$1/$2.sh
	sudo chown www-data:www-data /home/$1/$2.sh
	sudo chmod 705 /home/$1/$2.sh

	echo "#!/bin/bash" > /home/$1/$2.sh
	echo "clear" >> /home/$1/$2.sh
	echo "sudo docker exec -it $3 login" >> /home/$1/$2.sh
}

Firewall=$1-$2-$3-"Firewall"
Cliente01=$1-$2-$4-"Cliente01"
Cliente02=$1-$2-$5-"Cliente02"


sudo docker run -itd --privileged --name $Firewall -h $Firewall dvl-tcpip-servidor:1.0
sudo docker network connect Rede_Alunos $Firewall

IpGateway=$(sudo docker exec $Firewall route -n | grep UG | cut -f10 -d" ")

sudo docker exec $Firewall route add default gw 172.17.0.1
sudo docker exec $Firewall route del default gw $IpGateway

sudo docker run -itd --privileged --name $Cliente01 -h $Cliente01 --net Rede_Alunos dvl-tcpip-cliente:1.0
sudo docker exec $Cliente01 route del default gw $IpGateway

sudo docker run -itd --privileged --name $Cliente02 -h $Cliente02 --net Rede_Alunos dvl-tcpip-cliente:1.0
sudo docker exec $Cliente02 route del default gw $IpGateway






ScriptConecta $2 Conecta$Firewall $Firewall 

ScriptConecta $2 Conecta$Cliente01 $Cliente01 

ScriptConecta $2 Conecta$Cliente02 $Cliente02 


