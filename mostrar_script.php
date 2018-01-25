<?php

	session_start();
	if (!isset($_SESSION["login"]) || !isset($_SESSION["senha"])) {
		header("Location: login.html");
		exit;
	}

	$id = $_POST['id_cenario'];
	$caminho = $_POST['caminho'];
	$nome = $_POST['nome_cenario'];
	$descricao = $_POST['descricao'];
	$permissao = $_POST['permissao'];
	$pertence = $_POST['pertence'];

	$login = $_SESSION["login"];
	shell_exec("rm matriculas/matriculas_$login.txt");
	shell_exec("touch matriculas/matriculas_$login.txt");
	$script = shell_exec("cat $caminho/miolo.txt");

?>



<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Script</title>
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
				<h1>Script</h1>
				<h3>Nome: <?php echo "$nome"; ?></h3>
				<h3>Descrição: <?php echo "$descricao"; ?></h3>

				<form class="container" method="post" action="matriculas.php">
    				<div class="form-group">
<textarea class="form-control" rows="10" name="script" style="display: none;">
<?php
echo $script;
?>
</textarea>
<textarea class="form-control" rows="10" disabled>
<?php
echo $script;
?>
</textarea>
    				</div>
    				<div class="text-center">
    					<input type="hidden" name="caminho" value=<?php echo $caminho;?>>
    					<input type="hidden" name="id_ce" value=<?php echo $id;?>>

    					<?php $_SESSION['id_cenario']=$id; ?>

    					<input type="submit" class="btn btn-primary btn-lg" name="butao" value="Voltar">
    					<input type="button" class="btn btn-lg" id="editar" value="Editar">
    					<input type="submit" class="btn btn-success btn-lg" name="butao" value="Próximo">
  					</div>
  				</form>

  				<form id="formeditar" method="post" action="cenario_do_zero.php">
  					<input type="hidden" name="id" value=<?php echo $id;?>>
  					<input type="hidden" name="nome" value=<?php echo "\"$nome\"";?>>
  					<input type="hidden" name="descricao" value=<?php echo "\"$descricao\"";?>>
  					<input type="hidden" name="corpo" value=<?php echo "\"$script\"";?>>
  					<input type="hidden" name="permissao" value=<?php echo $permissao;?>>
  					<input type="hidden" name="caminho" value=<?php echo $caminho;?>>
  					<input type="hidden" name="pertence" id="pertence" value=<?php echo $pertence;?>>
  				</form>
<br><br>

			</div>

		</section>
<script src="js/jquery.min.js"></script>
<script type="text/javascript">
	$('#editar').click(function(){
		var pertence = document.getElementById('pertence').value;

		if (pertence == 'Sim') {
			var resposta = confirm("Você é o dono, deseja editar/copiar esté cenário?");
			if (resposta == true) {
				document.getElementById('formeditar').submit();
			}
		}else{
			var resposta = confirm("Você não é dono, deseja fazer uma cópia?");
			if (resposta == true) {
				document.getElementById('formeditar').submit();
			}
		}



	});
</script>
	</body>
</html>