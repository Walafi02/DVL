<?php
	$host = "localhost";
	$user = "root";
	$pass = "";
	$banco = "cadastro";

	$conexao = mysqli_connect($host, $user, $pass, $banco) or die("<p style='text-align: center;'>Senha da Base de Dados Incorreta!</p>");
?>