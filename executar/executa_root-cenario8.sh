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

cliente=$1-$2-$3-"cliente"
servidor=$1-$2-$4-"servidor"


sudo docker run -itd --privileged --name $cliente -h $cliente --net bridge dvl-ubuntu-base:1.0

sudo docker run -itd --privileged --name $servidor -h $servidor dvl-ubuntu-base:1.0


ScriptConecta $2 Conecta$cliente $cliente 

ScriptConecta $2 Conecta$servidor $servidor 


