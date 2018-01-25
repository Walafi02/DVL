<?php

$login = $_POST['login'];
$acao = $_POST['acao'];
$id_cenario = $_POST['id_cenario'];
$matricula = $_POST['matricula'];

include 'conexao.php';


switch ($acao) {
	case 'restartar':
		$query = "SELECT * FROM containers WHERE id_usuario = (SELECT id FROM usuarios WHERE login = '$login') AND id_cenario = '$id_cenario' AND matricula = '$matricula'";

		$sql = mysqli_query($conexao, $query);

		while($exibe = mysqli_fetch_assoc($sql)){
				$id = $exibe['id'];
				$nome = $exibe['nome'];
				shell_exec("sudo docker rm -f $nome 2>/dev/null >/dev/null &");

				$atualizar = "UPDATE containers SET estado = 0 WHERE id = $id";
				mysqli_query($conexao, $atualizar);
			}

		break;

	case 'startar':
		$query = "SELECT * FROM containers WHERE id_usuario = (SELECT id FROM usuarios WHERE login = '$login') AND id_cenario = '$id_cenario' AND matricula = '$matricula'";
		$sql = mysqli_query($conexao, $query);

		while($exibe = mysqli_fetch_assoc($sql)){
				$id = $exibe['id'];

				$atualizar = "UPDATE containers SET estado = 2 WHERE id = $id";
				mysqli_query($conexao, $atualizar);
			}
		break;

	case 'stop':
		$query = "SELECT * FROM containers WHERE id_usuario = (SELECT id FROM usuarios WHERE login = '$login') AND id_cenario = '$id_cenario' AND matricula = '$matricula'";
		$sql = mysqli_query($conexao, $query);

		while($exibe = mysqli_fetch_assoc($sql)){
				$id = $exibe['id'];

				$atualizar = "UPDATE containers SET estado = 3 WHERE id = $id";
				mysqli_query($conexao, $atualizar);
			}

		break;

	case 'deletar':
		$query = "SELECT * FROM containers WHERE id_usuario = (SELECT id FROM usuarios WHERE login = '$login') AND id_cenario = '$id_cenario' AND matricula = '$matricula'";
		$sql = mysqli_query($conexao, $query);

		while($exibe = mysqli_fetch_assoc($sql)){
				$id = $exibe['id'];

				$atualizar = "UPDATE containers SET estado = 5 WHERE id = $id";
				mysqli_query($conexao, $atualizar);
			}
		break;
	}

mysqli_close($conexao);

?>