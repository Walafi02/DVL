# Guia de Instalação

Este tutorial contempla a instalação da ferramenta Docker Virtual Lab(DVL), um gerenciador de containers Docker voltado para o âmbito universitário, onde a mesma disponibiliza Containers Docker para os alunos elaborarem as práticas de laboratórios.

### Softwares Necessários:
- Ubuntu 16.04.3 LTS
- Docker version 1.13.1
- Apache2
- PHP 7.0.22
- MySQL 5.7.21

## Instalação

### Passo 1: Projeto
Para se inicia o processo de instalação do DVL é necessário entrar com permissão de superusuário e importar o projeto direto do github no diretorio a escolha do usuário:
```
sudo su
git clone https://github.com/Walafi02/DVL.git
```

### Passo 2: LAMP
- Pacotes necessários para a instalação do LAMP:
```
apt-get update
apt-get install -y apache2
service apache2 restart
apt-get install -y php7.0 libapache2-mod-php7.0 mysql-server php7.0-mysql python-mysqldb
a2enmod rewrite
service apache2 restart
```

_**Obs.:** Neste processo será pedido ao usuário uma senha referente a senha de acesso do banco de dados MySql. É de extrema importância que a senha seja atualizada no arquivo conexao.php, no diretório busca_banco, na variavel $pass e no arquivo addUserProf.py, no diretório arquivos, na variavel self.passwd. Ou se preferir execute o script senhaBD.py, no diretorio arquivos, onde mesmo irá requisitar a senha do banco de dados, verificar se a mesma é valida e alterar nos arquivos necessários:_

```
cd DVL/arquivos
./senhaBD.py
```

- O próximo passo será alterar o diretório padrão do Apache nos seguintes arquivos:
1º Arquivo: apache2.conf, no diretorio /etc/apache2:
```
nano /etc/apache2/apache2.conf
```

Altera de:
```
<Directory /var/www/html/>
	Options Indexes FollowSymLinks
   	AllowOverride All
   	Require all granted
</Directory>
```
Para:
```
<Directory /<Caminho Completo do Diretorio do Projeto>/>
	Options Indexes FollowSymLinks
	AllowOverride All
	Require all granted
</Directory>
```
2º Arquivo: 000-default.conf, no diretório /etc/apache2/sites-available:
```
nano /etc/apache2/sites-available/000-default.conf
```

Altera de:
```
DocumentRoot /var/www/html
```
Para:
```
DocumentRoot /<Caminho Completo do Diretório do Projeto>
```

- Por fim, a configuração do banco de dados, onde o primerio passo é entrar no servidor MySQL:
```
mysql -h localhost -u root -p
```

Crie o Banco de Dados:
```
create database cadastro;
quit;
```

Importe o Banco
```
mysql -u root -p cadastro < cadastro.sql
```

_**Obs.:** A qualquer momento a senha do banco de dados será requitada._

- Restarta o servidor Apache:
```
service apache2 restart
```

### Passo 3: Docker
Para a instalação do docker, pode-se optar pela execução do script installDocker.sh, no diretório arquivos do projeto:
```
./installDocker.sh
```

ou pode-se optar pela instalação manual com:
```
apt-get install -y docker.io
```

Baixe as imagens, renomeias e exclua a imagem antiga:
```
docker pull walafi02/dvl-seguranca-cliente
docker tag 591320583f2537352f196c8295aa3b2c83f8a0a91ca2148ee8bccdfac5e430bc dvl-seguranca-cliente:1.0
docker rmi walafi02/dvl-seguranca-cliente

docker pull walafi02/dvl-seguranca-servidor
docker tag 88d7f10d6ce488de491d056f03aa727eb5edf2e4a83f19b986d929d13d4a2513 dvl-seguranca-servidor:1.0
docker rmi walafi02/dvl-seguranca-servidor

docker pull walafi02/dvl-tcpip-cliente
docker tag 8874008269472fc05a437516739b0274fee168f34b02bc869603e440a568f2b2 dvl-tcpip-cliente:1.0
docker rmi walafi02/dvl-tcpip-cliente

docker pull walafi02/dvl-tcpip-servidor
docker tag ecca252589f76c02708269c838e4f202245a27454d6b27a73af10150e5588ffd dvl-tcpip-servidor:1.0
docker rmi walafi02/dvl-tcpip-servidor

docker pull walafi02/dvl-bd-cliente
docker tag cd66278431a943816264e2ab7c66e92440c2de70802afb5e56c57dfba790acce dvl-bd-cliente:1.0
docker rmi walafi02/dvl-bd-cliente

docker pull walafi02/dvl-bd-servidor
docker tag cd66278431a943816264e2ab7c66e92440c2de70802afb5e56c57dfba790acce dvl-bd-servidor:1.0
docker rmi walafi02/dvl-bd-servidor

docker pull walafi02/dvl-ubuntu-base
docker tag 47247bb33fd56bbe9562ccae3254027306e39c6ff8c7ea6a15a0e2ee7b48be6a dvl-ubuntu-base:1.0
docker rmi walafi02/dvl-ubuntu-base

docker pull walafi02/dvl-ubuntu-completo
docker tag 2e3d6291161d04829af22035f3f67be08edf81f51925a2e13a59ab4117c31249 dvl-ubuntu-completo:1.0
docker rmi walafi02/dvl-ubuntu-completo
```

Crie as redes:
```
docker network create --driver bridge Rede_Alunos
docker network create --driver bridge Rede1
docker network create --driver bridge Rede2
```

### Passo 4: Configurações Finais
Por final, é necessário fazer algumas configurações finais. execultando o Script confFinais.sh:
```
./confFinais.sh
```

Ou faça as configurações manual:
- Adicionando os comandos que os usuário da ferramenta poderam execulta com privilegios sem uso de senha. Para isso, configuramos o arquivos sudors, no diretorio /etc:
```
nano /etc/sudors
```

No final do arquivo adiciona as seguintes linhas de código:
```
www-data	ALL=NOPASSWD: ALL
%alunos ALL=NOPASSWD: \
       	/usr/bin/docker exec -it * login
```

- Dando permissão de execursão ao arquivo add.sh, no diretorio /users:
```
cd ../users
chmod 764 add.sh
```

- Mudedando o dono dos arquivos e diretórios do projeto:
```
cd ../..
chown www-data.www-data -R DVL
```

## Utilizando a ferramenta

Para fazer uso da ferramenta é necessário iniciar um browser, de preferência Chrome, e acessar o IP do servidor. Mais informações sobre o uso da ferramenta estarão disponíveis [aqui](https://www.dropbox.com/s/lhrgwlskt2nyngy/TCC2WalafiFerreira.pdf?dl=0).

Para adicionar seu proprio usuário execulte o Script addUserProf.py, no diretorio arquivos:
```
cd DVL/arquivos
./addUserProf.py
```

Apos isso a ferramenta está pronta para o uso.

### Vídoes
- Vídeo para a o passo a passo a instalação da ferramenta [aqui](https://youtu.be/eRcBf8hG98w) 
- Vídeo para demonstrar as funcionalidades da ferramenta [aqui](https://youtu.be/um97ebPY8Io)
