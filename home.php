<?php
	session_start();
	if (!isset($_SESSION["login"]) || !isset($_SESSION["senha"])) {
		header("Location: login.html");
		exit;
	}

?>


<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Home</title>
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
					    	<?php if ($_SESSION["login"] == "root" && $_SESSION["siape"] == "100000") { ?>
					    		<li><a href="gerencia.php">Gerência</a></li>
					    	<?php } ?>
					    	<li><a href="logout.php"><?php echo $_SESSION['login'] ."(Logout)"; ?></a></li>
							</ul>
					</nav>
				</div>

				<h1 class="text-center">Docker Virtual LAB - DVL</h1>
			</div>
		</header>

		<section>
			
			<div class="container">
				<h1>Opções:</h1>
				<a href="cenarios.php" title="Lista todos os cenários disponiveis.">
					<h2><li class="esquerda">Iniciar Cenário</li></h2>
				</a>
				
				<a href="cenarios_em_segundo_plano.php" title="Mostra o estado dos cenários criados.">
					<h2><li class="esquerda">Listar Cenários Criados</li></h2>
				</a>

				<a href="cenario_do_zero.php" title="Cria um cenário do zero.">
					<h2><li class="esquerda">Criar Cenário</li></h2> 
				</a>
			</div>

		</section>
	</body>
</html>