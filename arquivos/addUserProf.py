#!/usr/bin/python

import os
import MySQLdb
import getpass
import hashlib

class Banco:
	def __init__(self):
		self.host = "localhost"
		self.user = "root"
		self.passwd = "root"
		self.bd = "cadastro"

		self.conexao = MySQLdb.connect(self.host, self.user, self.passwd, self.bd)
		self.cursor = self.conexao.cursor()

	def verifica(self, login):
		self.cursor.execute("SELECT * FROM usuarios WHERE login = '%s'" % (login))
		return len(self.cursor.fetchall())

	def add(self, login, senha):
		self.cursor.execute("INSERT INTO usuarios (tipo, login, senha) VALUES ('comum', '%s', '%s');" % (login, hashlib.md5(senha).hexdigest()))
		self.conexao.commit()

	def close(self):
		self.conexao.close()


banco = Banco()

while True:
	os.system("clear")
	login = raw_input("Login: ")
	senha = getpass.getpass('Senha: ')
	repeteSenha = getpass.getpass('Repita a Senha: ')

	if banco.verifica(login) > 0:
		os.system("clear")
		raw_input("Login ja existente!")

	elif senha != repeteSenha:
		os.system("clear")
		raw_input("Senhas Nao Sao idanticas!")
	
	elif len(senha) < 8:
		os.system("clear")
		raw_input("Senha Muito Curta!")
	
	else:
		banco.add(login, senha)
		os.system("clear")
		raw_input("Processo Bem Secedido!")
		break

banco.close()