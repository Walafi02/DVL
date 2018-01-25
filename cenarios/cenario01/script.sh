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

Maquina=$1-$2-$3-"Maquina"
sudo docker run --privileged -itd -h $Maquina --name $Maquina ubuntu:14.04

ScriptConecta $2 Conecta$Maquina $Maquina 

