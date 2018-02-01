#!/usr/bin/python

import os
import MySQLdb
import getpass

while True:
 	os.system("clear")
 	passwd = getpass.getpass('Senha: ')

 	try:
 		conexao = MySQLdb.connect("localhost", "root", passwd, "mysql")
 		conexao.close()

		os.system("sed -ie \"s/\$pass =.*/\$pass = \\\"%s\\\";/g\" ../busca_banco/conexao.php" % (passwd))
		os.system("sed -ie \"s/self.passwd =.*/self.passwd = \\\"%s\\\"/g\" addUserProf.py" % (passwd))

 		os.system("clear")
 		print "Senha Atualizado nos Arquivos"
 		break
 	except:
 		os.system("clear")
 		raw_input("Senha Errada!")
