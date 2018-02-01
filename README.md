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
Para se inicia o processo de instalação do DVL é necessário importar o projeto direto do github no diretorio a escolha do usuário:
```
$ git clone https://github.com/Walafi02/DVL.git
```

### Passo 2: LAMP
- Pacotes necessários para a instalação do LAMP:
```
$ sudo apt-get install -y apache2
$ sudo service apache2 restart
$ sudo apt-get install -y php7.0 libapache2-mod-php7.0
$ sudo apt-get install -y mysql-server php7.0-mysql python-mysqldb
$ sudo a2enmod rewrite
$ sudo service apache2 restart
```

_**Obs.:** Neste processo será pedido ao usuário uma senha referente a senha de acesso do banco de dados MySql. É de extrema importância que a senha seja atualizada no arquivo conexao.php, no diretório busca_banco, na variavel $pass e no arquivo addUserProf.py, no diretório arquivos, na variavel self.passwd. Ou se preferir dê permissão de execução ao Script senhaBD.py no diretorio arquivos, e executio que o mesmo irá requisitar a senha do banco de dados, verificar se a mesma é valida e alterar nos arquivos necessários:_

```
$ cd DVL/arquivos
$ chmod 764 senhaBD.py
$ sudo ./senhaBD.py
```

- O próximo passo será alterar a pasta padrão do apache nos seguintes arquivos:
1º Arquivo: apache2.conf, no diretorio /etc/apache2:
```
$ sudo nano /etc/apache2/apache2.conf
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
$ sudo nano /etc/apache2/sites-available/000-default.conf
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
$ mysql -h localhost -u root -p
```

Crie o Banco de Dados:
```
mysql> create database cadastro;
mysql> quit;
```

Importe o Banco
```
$ mysql -u root -p cadastro < cadastro.sql
```

_**Obs.:** A qualquer momento a senha do banco de dados será requitada._

- Restarta o servidor Apache:
```
sudo service apache2 restart
```

### Passo 3: Docker
Para a instalação do docker, pode-se optar pela execução de um script installDocker.sh, no diretório arquivos do projeto, para isso é necessário dá ao mesmo permissão de execução e logo após executá-lo::
```
$ chmod 764 installDocker.sh
$ sudo ./installDocker.sh
```

ou pode-se optar pela instalação manual com:
```
$ sudo apt-get install -y docker.io
```

Baixe as imagens, renomeias e exclua a imagem antiga:
```
$ sudo docker pull walafi02/dvl-seguranca-cliente
$ sudo docker tag 591320583f2537352f196c8295aa3b2c83f8a0a91ca2148ee8bccdfac5e430bc dvl-seguranca-cliente:1.0
$ sudo docker rmi walafi02/dvl-seguranca-cliente

$ sudo docker pull walafi02/dvl-seguranca-servidor
$ sudo docker tag 88d7f10d6ce488de491d056f03aa727eb5edf2e4a83f19b986d929d13d4a2513 dvl-seguranca-servidor:1.0
$ sudo docker rmi walafi02/dvl-seguranca-servidor

$ sudo docker pull walafi02/dvl-tcpip-cliente
$ sudo docker tag 8874008269472fc05a437516739b0274fee168f34b02bc869603e440a568f2b2 dvl-tcpip-cliente:1.0
$ sudo docker rmi walafi02/dvl-tcpip-cliente

$ sudo docker pull walafi02/dvl-tcpip-servidor
$ sudo docker tag ecca252589f76c02708269c838e4f202245a27454d6b27a73af10150e5588ffd dvl-tcpip-servidor:1.0
$ sudo docker rmi walafi02/dvl-tcpip-servidor

$ sudo docker pull walafi02/dvl-bd-cliente
$ sudo docker tag cd66278431a943816264e2ab7c66e92440c2de70802afb5e56c57dfba790acce dvl-bd-cliente:1.0
$ sudo docker rmi walafi02/dvl-bd-cliente

$ sudo docker pull walafi02/dvl-bd-servidor
$ sudo docker tag cd66278431a943816264e2ab7c66e92440c2de70802afb5e56c57dfba790acce dvl-bd-servidor:1.0
$ sudo docker rmi walafi02/dvl-bd-servidor

$ sudo docker pull walafi02/dvl-ubuntu-base
$ sudo docker tag 47247bb33fd56bbe9562ccae3254027306e39c6ff8c7ea6a15a0e2ee7b48be6a dvl-ubuntu-base:1.0
$ sudo docker rmi walafi02/dvl-ubuntu-base

$ sudo docker pull walafi02/dvl-ubuntu-completo
$ sudo docker tag 2e3d6291161d04829af22035f3f67be08edf81f51925a2e13a59ab4117c31249 dvl-ubuntu-completo:1.0
$ sudo docker rmi walafi02/dvl-ubuntu-completo
```

Crie as redes:
```
$ sudo docker network create --driver bridge Rede_Alunos
$ sudo docker network create --driver bridge Rede1
$ sudo docker network create --driver bridge Rede2
```

### Passo 4: Configurações Finais
Por final, é necessário fazer algumas configurações finais. Para dê permissão de execulção para o Script confFinais.sh e o execulte:
```
$ chmod 764 confFinais.sh
$ sudo ./confFinais.sh
```

Ou faça as configurações manuair:
- Adicionando os comandos que os usuário da ferramenta poderam execulta com privilegios sem uso de senha. Para isso, configuramos o arquivos sudors, no diretorio /etc:
```
$ sudo nano /etc/sudors
```

No final do arquivo adiciona as seguintes linhas de código:
```
www-data ALL=NOPASSWD:   ALL
%alunos ALL=NOPASSWD: \
       	/usr/bin/docker exec -it * login
```

- Dando permissão de execursão ao arquivo add.sh, no diretorio /users:
```
$ cd ../users
$ sudo chmod 764 add.sh
```

- Mudedando o dono dos arquivos e diretórios do projeto:
```
$ cd ../..
$ sudo chown www-data.www-data -R DVL
```

## Utilizando a ferramenta

Para fazer uso da ferramenta é necessário iniciar um browser, de preferência Chrome, e acessar o IP do servidor. Mais informações sobre o uso da ferramenta estarão disponíveis [aqui](https://www.google.com.br/).

Para adicionar seu proprio usuário execulte o Script addUserProf.py, no diretorio arquivos, dando permissão de execulção ao mesmo:
```
$ cd DVL/arquivos
$ chmod 764 addUserProf.py
$ sudo ./addUserProf.py
```

Apos isso a ferramenta está pronta para o uso.
