<?php
	session_start();
	if (!isset($_SESSION["login"]) || !isset($_SESSION["senha"])) {
		header("Location: login.html");
		exit;
	}

	if ($_SESSION["login"] != "root" || $_SESSION["siape"] != "100000") {
		header("Location: home.php");
		exit;
	}

?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Gerenciamento de Usuários</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/estilo.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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
				<div class="col-md-8 col-md-offset-2">

					<table class="table table-hover">
					  	<thead class="thead-default ">
					    	<tr>
								<th class="text-center">Siape</th>
					      		<th class="text-center">Nome</th>
								<th class="text-center">Ação</th>
					    	</tr>
					  	</thead>
					  	
					  	<tbody class="text-center" id="users">
						    
					    </tbody>
					</table>
					<p class="text-center"><a href=#>Adicionar Novo Usuário</a></p>

				</div>
			</div>
		</section>

	<script type="text/javascript">
		mostrar()

		function mostrar(){
			var dados = {
				acao: 'getUsuarios'
			}

			$.post('busca_banco/gerenciaUsuarios.php', dados, function(retorna){
				//alert(retorna)
				$("#users").html(retorna);
			});
		}
	</script>
	</body>
</html>