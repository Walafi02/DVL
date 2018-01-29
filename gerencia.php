<?php
	session_start();
	if (!isset($_SESSION["login"]) || !isset($_SESSION["senha"])) {
		header("Location: login.html");
		exit;
	}

	if ($_SESSION["tipo"] != "master") {
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
								<th class="text-center">Nome</th>
					      		<th class="text-center">Tipo de Usuário</th>
					    	</tr>
					  	</thead>
					  	
					  	<tbody class="text-center" id="users">
						    
					    </tbody>
					</table>
					<p class="text-center"><a onclick="addUser()" href=#>Adicionar Novo Usuário</a></p>

				</div>
			</div>
		</section>



<!-- modal adicionar usuario -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-center" id="myModalLabel">Dados do Usuário</h4>
			</div>
			
			<div class="modal-body">











<form class="form-horizontal" id="formulario">

    <div class="form-group">
        <label for="login" class="col-sm-3 control-label">Login</label>
        <div class="col-sm-8">
            <input type="Text" class="form-control" id="login" name="login" placeholder="Login" autofocus="1">
        </div>
    </div>

    <div class="form-group">
        <label for="Tipo" class="col-sm-3 control-label">Tipo de Usuário</label>
        <div class="col-sm-8">
            <select class="form-control" id="sel1">
		    	<option value="comum">Usuário Comum</option>
		    	<option value="master">Usuário Master</option>
		  	</select>
        </div>
    </div>    

    <div class="form-group">
        <label for="senha" class="col-sm-3 control-label">Senha</label>
        <div class="col-sm-8">
            <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required>
        </div>
    </div>
</form>












			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-success" onclick="adicionar()">Adicionar</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


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

		function addUser(){
			$('#formulario')[0].reset();
			$("#add").modal('show');
			$("#login").focus();
		}

		function adicionar(){
			var nome = $("#login").val();
			var tipo = $("#sel1").val();
			var senha = $("#senha").val();

			if (nome == "") {
				alert("É necessario adicionar um nome");
				$("#login").focus();
			} else if (senha == "") {
				alert("É necessario adicionar uma Senha");
				$("#senha").focus();
			}else if (senha.length < 8) {
				alert("Senha Curta");
				$("#senha").val("");
				$("#senha").focus();
			}else {
				var dados = {
					acao: 'addUsuario',
					nome: nome,
					tipo: tipo,
					senha: senha
				}

				$.post('busca_banco/gerenciaUsuarios.php', dados, function(retorna){
					if (retorna == 1) {
						alert("Login Já Existente!");
						$("#login").val("");
						$("#login").focus();
					}else {
						mostrar()

						$("#add").modal('hide');
					}
				});

			}
		}
	</script>
	</body>
</html>