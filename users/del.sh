#!/bin/bash

while read matricula
do

	sudo userdel -f $matricula >> /dev/null
	sudo rm -rf /home/$matricula/

done < matriculas.txt

sudo echo -n > matriculas.txt
sudo chmod 666 matriculas.txt