<?php

	session_start();

	if (!isset($_SESSION["login"]) || !isset($_SESSION["senha"])) {
		header("Location: login.html");
		exit;
	}

	if ($_POST['butao'] == "Voltar") {
		header("Location: cenarios.php");
		exit;
	}

	$login = $_SESSION["login"];

	if ($_POST['id_ce']) $_SESSION['id_cenario'] = $_POST['id_ce'];

	$id_cenario = $_POST['id_ce'];

//monta o script
	if (isset($_POST['caminho'])) {

		$aa = 1;
		shell_exec("rm matriculas/matriculas_$login.txt");
		$caminho = $_POST['caminho'];
		shell_exec("rm executar/executa_$login-cenario$id_cenario.sh");

	//	$text = $_POST['numero'];
		$inicio = shell_exec("cat $caminho/inicio.txt");
		$script = shell_exec("cat $caminho/miolo.txt");
		//$script = $_POST['script'];
		$fim = shell_exec("cat $caminho/final.txt");

		$mat = fopen("executar/executa_$login-cenario$id_cenario.sh", "a");
		$escreve = fwrite($mat, "$inicio\n");
		$escreve = fwrite($mat, "$script\n");
		$escreve = fwrite($mat, "$fim\n");
		fclose($mat);

		shell_exec("perl -pi -e 's/\r/\n/g' executar/executa_$login-cenario$id_cenario.sh");
		shell_exec("chmod 764 executar/executa_$login-cenario$id_cenario.sh");

	}

	$matr = shell_exec("cat matriculas/matriculas_$login.txt");


?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Matrículas</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/estilo.css">
	</head>
	
	<body>
		<header>
			<div class="jumbotron">
				<div class="opcoes container">
					<nav >
						<ul>
					    	<li><a href="home.php">Home</a></li>
					    	<li><a href="logout.php"><?php echo $_SESSION['login'] ."(Logout)"; ?></a></li>
							</ul>
					</nav>
				</div>

				<h1 class="text-center">Docker Virtual LAB - DVL</h1>
			</div>
		</header>

		<section>
			
			<div class="container">
				<h1>Matrículas</h1>

				<form class="container" method="post" action="tratar_usuario.php">
    				<div class="form-group col-md-4 col-md-offset-4 text-center">
<textarea id="matri" class="form-control" rows="10" disabled>
<?php echo $matr; ?>     						
</textarea>

    					<input type="number" name="numero" min="0" required placeholder="Nº da Matricula do Aluno" autofocus>
    					<br>
    					<input type="submit" class="btn btn-primary btn-lg" name="butao" value="Add">
    					<input type="submit" class="btn btn-danger btn-lg" name="butao" value="Del">
  				</form>
  				<form method="post" action="tratar_usuario.php">
  						<input type="hidden" name="id_c" value=<?php echo $id_cenario;?>>

    					<input type="submit" class="btn btn-success btn-lg" name="butao" value="Finalizar">
  					
  				</form>
  					</div>


			</div>

		</section>
		<input type="hidden" id="aa" value=<?php echo $aa; ?>>

<script type="text/javascript">
	if (document.getElementById('aa').value != "") {
//		document.getElementById('matri').value = "";
	}

</script>
	</body>
</html>
