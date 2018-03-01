#!/bin/bash

sudo echo "www-data        ALL=NOPASSWD:\\
                        /usr/bin/docker,\\
                        /usr/sbin/addgroup,\\
                        /usr/sbin/useradd,\\
                        /bin/echo *,\\
                        /usr/sbin/chpasswd,\\
                        /usr/bin/passwd,\\
                        /bin/rm senhas.txt,\\
                        /bin/chmod,\\
                        /bin/mv,\\
                        /bin/touch" >> /etc/sudoers

sudo echo "%alunos		ALL=NOPASSWD:\\
			/usr/bin/docker exec -it * login" >> /etc/sudoers

cd ../users
sudo chmod 764 add.sh

cd ../..
sudo chown www-data.www-data -R DVL
