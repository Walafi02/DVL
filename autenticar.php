

<?php

	include('busca_banco/conexao.php');

	$login = $_POST['login'];
	$senha = $_POST['senha'];

	$query = "SELECT * FROM usuarios WHERE login = '$login' and senha = '$senha'";

	$sql = mysqli_query($conexao, $query);
	$row = mysqli_num_rows($sql);


	$exibe = mysqli_fetch_assoc($sql);
	$id = $exibe['id'];
	$tipo = $exibe['tipo'];


	mysqli_close($conexao);

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Autenticar</title>
		<meta charset="utf-8">
		<script type="text/javascript" src="js/scripts.js"></script>
	</head>
	<body>
		<?php

			if ($row > 0) {
				session_start();
				$_SESSION['id']=$id;
				$_SESSION['tipo']=$tipo;
				$_SESSION['login']=$_POST['login'];
				$_SESSION['senha']=$_POST['senha'];


				//$login = $_POST['login'];
				shell_exec("php executa.php $login 2>/dev/null >/dev/null &");

				echo "<script>loginsuccessfully()</script>"; //redireciona para home do usuario
			} else {
			echo "<script>loginfailed()</script>";	//redireciona para a tela de login
		}

		?>

	</body>
</html>