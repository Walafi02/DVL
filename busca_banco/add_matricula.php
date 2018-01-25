<?php

$login = $_POST['login'];
$id_cenario = $_POST['id_cenario'];
$matricula = $_POST['matricula'];

if ($matricula != "") {
	
	include 'conexao.php';

	$query = "SELECT * FROM usuarios WHERE login = '$login'";
	$sql = mysqli_query($conexao, $query);
	$exibe = mysqli_fetch_assoc($sql);
	$id_usuario = $exibe['id'];

	$query = "SELECT * FROM containers WHERE id_usuario = '$id_usuario' AND id_cenario = '$id_cenario' AND matricula = '$matricula'";
	$sql = mysqli_query($conexao, $query);
	$row = mysqli_num_rows($sql);


	if (!shell_exec("grep '^$matricula:' /etc/passwd")) {
		echo "Não existe\n";
		shell_exec("echo $matricula >> ../users/matriculas.txt");
		shell_exec("./../users/add.sh $matricula");
	}

	if ($row == 0) {
		$query = "SELECT * FROM maquina WHERE id_cenario = $id_cenario";
		$sql = mysqli_query($conexao, $query);

		while($exibe = mysqli_fetch_assoc($sql)){
			$id = $exibe['id'];
			$nome = $exibe['nome'];

			$nome_maq = "$id_usuario-$matricula-$id-$nome";
			$inserir = "INSERT INTO `containers` (`id`, `id_usuario`, `id_cenario`, `id_maquina`, `matricula`, `nome`, `estado`) VALUES (NULL, '$id_usuario', '$id_cenario', '$id', '$matricula', '$nome_maq', '0')";

			mysqli_query($conexao, $inserir);
		}
	}
	
	mysqli_close($conexao);
}

?>