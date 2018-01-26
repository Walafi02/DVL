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

firewall=$1-$2-$3-"firewall"
cliente=$1-$2-$4-"cliente"

sudo docker run -itd --privileged --name $firewall -h $firewall dvl-seguranca-servidor:1.0
sudo docker network connect Rede_Alunos $firewall

IpGateway=$(sudo docker exec $firewall route -n | grep UG | cut -f10 -d" ")

sudo docker exec $firewall route add default gw 172.17.0.1
sudo docker exec $firewall route del default gw $IpGateway
sudo docker exec $firewall iptables -I POSTROUTING -t nat -o eth0 -j MASQUERADE

ip=$(sudo docker exec $firewall ifconfig eth1 | grep "inet addr" | cut -f2 -d: | cut -f1 -d" ")

sudo docker run -itd --privileged --name $cliente -h $cliente --net Rede_Alunos dvl-seguranca-cliente:1.0
sudo docker exec $cliente route del default gw $IpGateway
sudo docker exec $cliente route add default gw $ip


ScriptConecta $2 Conecta$firewall $firewall 

ScriptConecta $2 Conecta$cliente $cliente 

