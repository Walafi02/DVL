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

Servidor=$1-$2-$3-"Servidor"
Cliente=$1-$2-$4-"Cliente"


sudo docker run -itd --privileged --name $Servidor -h $Servidor --net Rede1 dvl-bd-servidor:1.0
sudo docker network connect Rede_Alunos $Servidor

sudo docker run -itd --privileged --name $Cliente -h $Cliente --net Rede2 dvl-bd-cliente:1.0
sudo docker network connect Rede_Alunos $Cliente



ScriptConecta $2 Conecta$Servidor $Servidor 

ScriptConecta $2 Conecta$Cliente $Cliente 


