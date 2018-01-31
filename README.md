# Guia de Instalação

Este tutorial contempla a instalação da ferramenta Docker Virtual Lab(DVL), um gerenciador de containers Docker voltado para o âmbito universitário, onde a mesma disponibiliza Containers Docker para os alunos elaborarem as práticas de laboratórios.

### Softwares necessários:
- Ubuntu 16.04.3 LTS
- Docker version 1.13.1
- Apache2
- PHP 7.0.22
- Mysql 5.7.21

## Instalação

### Passo 1º: Projeto
Para se inicia o processo de instalação do DVL é necessario importar o projeto direto do github no diretorio a escolha do usuário:
```
$ git clone https://github.com/Walafi02/DVL.git
```

### Passo 2º: LAMP
Pacotes necessários para a instalação do LAMP:
```
$ sudo apt-get install -y apache2
$ sudo service apache2 restart
$ sudo apt-get install -y php7.0 libapache2-mod-php7.0
$ sudo apt-get install -y mysql-server php7.0-mysql
$ sudo a2enmod rewrite
$ sudo service apache2 restart
```

Obs.: Neste processo será pedido ao usuário uma senha referente a senha de acesso do banco de dados MySql. É de extrema importância que a senha seja atualizada no arquivo conexao.php, no diretorio busca_banco, na variavel $pass.

O proximo passo será alterar a pasta padrão do apache nos seguintes arquivos:
- 1º Arquivo: apache2.conf, no diretorio /etc/apache2:
	$ sudo nano /etc/apache2/apache2.conf

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
- 2º Arquivo: 000-default.conf, no diretorio /etc/apache2/sites-available:
```
$ sudo nano /etc/apache2/sites-available/000-default.conf
```

Altera de:
```
DocumentRoot /var/www/html
```
Para:
```
DocumentRoot /<Caminho Completo do Diretorio do Projeto>
```

Por fim, a configuração do banco de dados, onde o primerio passo é entrar no servidor mysql:
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

OBS.: A qualquer momento a senha do banco de dados será requitada.

### Passo 3º: Docker
Para a instalação do docker, pode-se optar pela execulção de um script installDocker.sh, no diretorio arquivos do projeto, para isso é mecessario dá ao mesmo permissão de execulção e logo apos execulta-lo:
```
$ cd arquivos
$ chmod 764 installDocker.sh
$ sudo ./installDocker.sh
```

ou pode-se optar pela insttalação manual com:
```
$ sudo apt-get install -y docker.io
```

Baixe as imagens e as renomeias:
```
$ sudo ...
```

Crie as redes:
```
$ sudo docker network create --driver bridge Rede_Alunos
$ sudo docker network create --driver bridge Rede1
$ sudo docker network create --driver bridge Rede2
```

### Passo 4º: Configurações Finais
Por final, é necessario:
- Adicionar os comandos que os usuário da ferramenta poderam execulta com privilegios sem uso de senha. Para isso, configuramos o arquivos sudors, no diretorio /etc:
```
$ sudo nano /etc/sudors
```

No final do arquivo adiciona as seguintes linhas de código:
```
www-data ALL=NOPASSWD:   ALL
%alunos ALL=NOPASSWD: \
       	/usr/bin/docker exec -it * login
```

- Mude o dono dos arquivos e diretorios do projeto:
```
$ cd ../..
$ sudo chown www-data.www-data -R DVL
```

- Da permissão de execursão ao arquivo add.sh, no diretorio /users:
```
$ cd DVL/users
$ sudo chmod 764 add.sh
```
