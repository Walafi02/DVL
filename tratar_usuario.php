<?php
	session_start();
	if (!isset($_SESSION["login"]) || !isset($_SESSION["senha"])) {
		header("Location: login.html");
		exit;
	}

function AddBanco($login, $id_cenario){

		include('busca_banco/conexao.php');

			$arq = fopen ("matriculas/matriculas_$login.txt", "r");
			while (!feof ($arq)) {
				$matricula = intval(fgets($arq));
				//banco($conexao, $id_cenario, $login, intval($matricula));
				if ($matricula != "") {
					$query_user = "SELECT * FROM usuarios WHERE login = '$login'";
					$sql_user = mysqli_query($conexao, $query_user);
					$exibe_user = mysqli_fetch_assoc($sql_user);

					$id_user = $exibe_user['id'];

					$query = "SELECT * FROM maquina WHERE id_cenario = $id_cenario";
					$sql = mysqli_query($conexao, $query);

					while($exibe = mysqli_fetch_assoc($sql)){
						$id = $exibe['id'];
						$nome = $exibe['nome'];

						$nome_maq = "$id_user-$matricula-$id-$nome";
						$inserir = "INSERT INTO `containers` (`id`, `id_usuario`, `id_cenario`, `id_maquina`, `matricula`, `nome`, `estado`) VALUES (NULL, '$id_user', '$id_cenario', '$id', '$matricula', '$nome_maq', '0')";

						mysqli_query($conexao, $inserir);
					}
				}
			}
			fclose ($arq);

	mysqli_close($conexao);
}

$id_cenario = $_SESSION["id_cenario"];
$login = $_SESSION["login"];

$acao = $_POST['butao'];
switch ($acao) {
	case 'Add':
		$text = $_POST['numero'];
//shell_exec("echo aaa > /tmp/saida.txt");
//		shell_exec("touch matriculas/matriculas_$login.txt");

		if (!shell_exec("grep '^$text\$' matriculas/matriculas_$login.txt") && is_numeric($text)) {
			$mat = fopen("matriculas/matriculas_$login.txt", "a");
			$escreve = fwrite($mat, "$text\n");
			fclose($mat);

			if (!shell_exec("grep '^$text:' /etc/passwd")) {
				shell_exec("echo $text >> users/matriculas.txt");
				shell_exec("./users/add.sh $text");
			}
		}
		header("Location: matriculas.php");
		//exit;
		break;
	
	case 'Del':
		$text = $_POST['numero'];

		shell_exec("sed -i '/^$text\$/d' matriculas/matriculas_$login.txt");
		header("Location: matriculas.php");
		//exit;
		break;

	case 'Finalizar':
		//add no banco
		if(filesize("matriculas/matriculas_$login.txt") > 0){

			AddBanco($login, $id_cenario);

			//executa e atualiza no banco
			shell_exec("php executa.php $login 2>/dev/null >/dev/null &");

			header("Location: cenarios_em_segundo_plano.php");
		}else{
			header("Location: matriculas.php");
		}
		break;

	default:
		header("Location: home.php");
		//		exit;
		break;
}

exit;

/*
if ($_POST['butao'] == "Add") {
	$text = $_POST['numero'];

	if (!shell_exec("grep $text matriculas/matriculas_$login.txt")) {

		$mat = fopen("matriculas/matriculas_$login.txt", "a");
		$escreve = fwrite($mat, "$text\n");
		fclose($mat);

		if (!shell_exec("grep $text /etc/passwd")) {
			shell_exec("./users/add.sh $text");
		}
	}
	header("Location: matriculas.php");
	exit;
	
	}elseif ($_POST['butao'] == "Del") {
		$text = $_POST['numero'];

		shell_exec("sed -i '/^$text\$/d' matriculas/matriculas_$login.txt");
		header("Location: matriculas.php");
		exit;		
		}elseif ($_POST['butao'] == "Finalizar") {

			//add no banco
			AddBanco($login, $id_cenario);

			//executa e atualiza no banco
			shell_exec("php executa.php $login 2>/dev/null >/dev/null &");

			header("Location: cenarios_em_segundo_plano.php");
			exit;

			}else {
				header("Location: home.php");
				exit;
				}
*/

?>
