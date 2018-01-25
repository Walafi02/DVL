#!/bin/bash

clear
ip=2
docker network create --driver bridge Rede_Alunos &> /dev/null && echo "Rede Criada"
# cria uma rede


function ScriptConecta {
        touch /home/$1/$2.sh
        chmod 705 /home/$1/$2.sh

        echo "#!/bin/bash" > /home/$1/$2.sh
        echo "sudo docker attach $3" > /home/$1/$2.sh
}




while read matricula
do

        echo "Criando Cenario do Usuario $matricula"

#	docker network create --driver bridge rede_usuario_$matricula &> /dev/null && echo "Rede Criada"

        ##nome das maquinas##
        gateway=$2$matricula
        c01=$3$matricula
        c02=$4$matricula


        ##Maquina Gateway##
        sudo docker run --privileged -itd -h $gateway --name $gateway ubuntu:1.0 /bin/bash
        #cria a imagem encaminhadora de pacotes


        sudo docker network connect Rede_Alunos $gateway
        #conectando a sengunda interface

##        docker exec $gateway apt-get update &> /dev/null && echo "Pacotes Atualizados"
##        docker exec $gateway apt-get install -y iptables &> /dev/null && echo "Instalando iptables"
        #atualiza os pacotes e instala o iptables


#        docker exec $gateway iptables -I POSTROUTING -t nat -o eth0 -j MASQUERADE
        #habilita o nat para encaminhar pacotes

        sudo docker exec $gateway ifconfig eth1 0
        #configura a segunda interface

##maquina 01##

        sudo docker run --privileged -itd -h $c01 --name $c01 --net Rede_Alunos ubuntu:1.0 /bin/bash
        #sobe o segundo container com a rede antes criada

        sudo docker exec $c01 ifconfig eth0 0
        #configurando a segunda interface

#        docker exec $c01 route add default gw 10.1.$ip.1 eth0
        #define uma rota para ser encaminhado os pacotes

##maquina 02##

        sudo docker run --privileged -itd -h $c02 --name $c02 --net Rede_Alunos ubuntu:1.0 /bin/bash | cut -b 1-10
        #sobe o segundo container com a rede antes criada

        sudo docker exec $c02 ifconfig eth0 0
        #configurando a segunda interface

#        docker exec $c02 route add default gw 10.1.$ip.1 eth0
        #define uma rota para ser encaminhado os pacotes


#        ip=$(($ip+2))

        ##funcao que cria um script para a conexao com as maquinas
	ScriptConecta $matricula ConectaGateway $gateway
	ScriptConecta $matricula ConectaMaquina01 $c01
	ScriptConecta $matricula ConectaMaquina02 $c02

done < matriculas/matriculas_$1.txt

