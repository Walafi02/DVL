<?php

$texto = $_POST['dados'];
$nome = $_POST['nome'];
$acao = $_POST['acao'];
$login = $_POST['login'];

if ($acao == 1) {
		
	shell_exec("mkdir -p /tmp/teste");

	$mat = fopen("/tmp/teste/script-$login.txt", "w");
	fwrite($mat, $texto);
	fclose($mat);

	//shell_exec("grep -w -v '\$$nome' /tmp/teste/script.txt > /tmp/teste/script1.txt; mv /tmp/teste/script1.txt /tmp/teste/script.txt");

	//$texto_final = shell_exec('cat /tmp/teste/script.txt');

	$texto_final = shell_exec("grep -w -v '\$$nome' /tmp/teste/script-$login.txt");

	echo $texto_final;
}else {
	//shell_exec("mkdir -p /tmp/teste");

	$mat = fopen("/tmp/script-$login.txt", "w");
	fwrite($mat, $texto);
	fclose($mat);

	//shell_exec("grep -w -v '\$$nome' /tmp/teste/script.txt > /tmp/teste/script1.txt; mv /tmp/teste/script1.txt /tmp/teste/script.txt");

	//$texto_final = shell_exec('cat /tmp/teste/script.txt');

	$texto_final = shell_exec("grep -w -v '$nome' /tmp/script-$login.txt");

	echo $texto_final;
}
?>