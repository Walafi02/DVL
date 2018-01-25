<?php
	$login = $argv[1];

	include 'busca_banco/conexao.php';

//executar estado 0
	$query = "SELECT id_cenario, matricula, id_usuario FROM containers WHERE id_usuario = (SELECT id FROM usuarios WHERE login = '$login') AND (id_cenario, matricula) not in (SELECT id_cenario, matricula FROM containers WHERE id_usuario = (SELECT id FROM usuarios WHERE login = '$login') and estado != 0 GROUP BY id_cenario, matricula) GROUP BY id_cenario, matricula, id_usuario";

	$sql = mysqli_query($conexao, $query);

	while($exibe = mysqli_fetch_assoc($sql)){
		$id_cenario = $exibe['id_cenario'];
		$matricula = $exibe['matricula'];
		$id_usuario = $exibe['id_usuario'];


	$arr = [];
	$query_ids = "SELECT * FROM maquina WHERE id_cenario = '$id_cenario'";
	$sql_ids = mysqli_query($conexao, $query_ids);

	while($exibe_ids = mysqli_fetch_assoc($sql_ids)){
		$id = $exibe_ids['id'];
		$arr[] = $id;
	}

	$str = implode(" ", $arr);

		shell_exec("./executar/executa_$login-cenario$id_cenario.sh $id_usuario $matricula $str");
	}


//executa estado 2
	$query = "SELECT * FROM containers WHERE id_usuario = (SELECT id FROM usuarios WHERE login = '$login') AND nome not in (SELECT nome FROM containers WHERE id_usuario = (SELECT id FROM usuarios WHERE login = '$login') and estado != 2)";


	$sql = mysqli_query($conexao, $query);

	while($exibe = mysqli_fetch_assoc($sql)){
		$nome = $exibe['nome'];
		$matricula = $exibe['matricula'];
		shell_exec("sudo mv /home/$matricula/.Conecta$nome.sh /home/$matricula/Conecta$nome.sh");
		shell_exec("sudo chmod 705 /home/$matricula/Conecta$nome.sh");

		shell_exec("sudo docker start $nome");
	}

//executa estado 4
	$query = "SELECT * FROM containers WHERE id_usuario = (SELECT id FROM usuarios WHERE login = '$login') AND nome not in (SELECT nome FROM containers WHERE id_usuario = (SELECT id FROM usuarios WHERE login = '$login') and estado != 3)";

	$sql = mysqli_query($conexao, $query);
	while($exibe = mysqli_fetch_assoc($sql)){
		$nome = $exibe['nome'];
		$matricula = $exibe['matricula'];
		shell_exec("sudo chmod 700 /home/$matricula/Conecta$nome.sh");
		shell_exec("sudo mv /home/$matricula/Conecta$nome.sh /home/$matricula/.Conecta$nome.sh");

		shell_exec("sudo docker stop $nome");
	}

//executa estado 6

	$query = "SELECT * FROM containers WHERE id_usuario = (SELECT id FROM usuarios WHERE login = '$login') AND nome not in (SELECT nome FROM containers WHERE id_usuario = (SELECT id FROM usuarios WHERE login = '$login') and estado != 5)";


	$sql = mysqli_query($conexao, $query);

	while($exibe = mysqli_fetch_assoc($sql)){
		$nome = $exibe['nome'];
		$id = $exibe['id'];
		$matricula = $exibe['matricula'];

		shell_exec("sudo docker rm -f $nome");
		shell_exec("sudo rm /home/$matricula/Conecta$nome.sh");
		shell_exec("sudo rm /home/$matricula/.Conecta$nome.sh");


		$deleta = "DELETE FROM `containers` WHERE id = '$id'";

		mysqli_query($conexao, $deleta);
	}


//atualiza o estado do container
	$query = "SELECT * FROM containers WHERE id_usuario = (SELECT id FROM usuarios WHERE login = '$login')";

	$sql = mysqli_query($conexao, $query);

	while($exibe = mysqli_fetch_assoc($sql)){
		$id = $exibe['id'];
		$nome = $exibe['nome'];

		$lastLine = exec("sudo docker inspect $nome | grep Status | cut -d'\"' -f 4");
		
		if ($lastLine == "running") {
			$alterar = "UPDATE `containers` SET `estado` = '1' WHERE `containers`.`id` = $id";
			}elseif ($lastLine == "exited") {
				$alterar = "UPDATE `containers` SET `estado` = '4' WHERE `containers`.`id` = $id";
				}else{
					$alterar = "UPDATE `containers` SET `estado` = '6' WHERE `containers`.`id` = $id";
					}

		mysqli_query($conexao, $alterar);
	}


  	mysqli_close($conexao);

?>
