<?php
	session_start();
	if (!isset($_SESSION["login"]) || !isset($_SESSION["senha"])) {
		header("Location: login.html");
		exit;
	}

	$login = $_SESSION["login"];
?>


<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Cenários em Segundo Plano</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/estilo.css">
		<script src="js/jquery.min.js"></script>
		<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
		<script src="js/bootstrap.min.js"></script>
		<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

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

				<div class="modal fade" id="myModal" role="dialog">
				    <div class="modal-dialog modal-sm">
				    
				      <!-- Modal content-->
				        <div class="modal-content">
				            <div class="modal-header">
				                <button type="button" class="close" data-dismiss="modal">&times;</button>
				                <h4 class="modal-title">Adicionar Aluno</h4>
				            </div>
				          
				            <div class="modal-body">
				                
				                <label for="matricula">Matricula</label>
				    	        <input type="number" name="matricula" id="matricula" autofocus>
				                
				            </div>
				          
				            <div class="modal-footer">
				                <button type="button" class="btn btn-success" onclick="add()" data-dismiss="modal">Add</button>
				                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				            </div>
				          
				        </div>
				      
				    </div>
				</div>


				<ul class="nav nav-tabs">
					<li class="active"><a data-toggle="pill" href="#home"><h2 onclick="aaa()">Cenários</h2></a></li>
				    <li><a data-toggle="pill" href="#menu1"><h2 onclick="aaa()">Containers</h2></a></li>
				</ul>
				  
				<div class="tab-content">
				    <div id="home" class="tab-pane fade in active">

				<div class="container">

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">Nome do Cenário</th>
									<th class="text-center">Estado do Cenário</th>
									<th class="text-center">Ação</th>
								</tr>
							</thead>

							<tbody id="cenarios">

							</tbody>
						</table>
					</div>	

				</div>

				    </div>
				    
				    <div id="menu1" class="tab-pane fade">
				      	
				<div class="container">

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="containers">
							
						</table>
					</div>	

				</div>


				    </div>
				</div>


			</div>

<input type="hidden" name="login" id="login" value=<?php echo $login; ?>>
<script>
	var	login = document.getElementById('login').value;
	mostrar()
	var intervalo = window.setInterval(mostrar, 1000);
	var cenario = 0;

	function mostrar(){
		var dados = {
			login: login
		}
		$.post('busca_banco/cenarios_em_execursao.php', dados, function(retorna){
				$("#cenarios").html(retorna);
			});

		$.post('busca_banco/containers_em_execursao.php', dados, function(retorna){
				$("#containers").html(retorna);
			});
	}

	function tratar_cenario(acao, id_cenario){
		var dados = {
			login: login,
			acao: acao,
			id_cenario: id_cenario 
		}

		$.post('busca_banco/trata_cenarios.php', dados);
		mostrar()
		$.post('atualiza.php', dados);

	}

	function tratar_container(acao, id_cenario, matricula){
		var dados = {
			login: login,
			acao: acao,
			id_cenario: id_cenario,
			matricula: matricula
		}

		$.post('busca_banco/trata_containers.php', dados);
		mostrar()
		$.post('atualiza.php', dados);

	}

	function aaa(){
		var dados = {
			login: login
		}
		$.post('atualiza.php', dados);
	}

	function add_user(id_cenario){
		document.getElementById('matricula').value = "";
		cenario = id_cenario;
		$("#myModal").modal();
	}


	function add(){
		var matricula = document.getElementById('matricula').value;
		
		dados = {
			login: login,
			id_cenario: cenario,
			matricula: matricula
		}

		$.post('busca_banco/add_matricula.php', dados);
		mostrar();
		$.post('atualiza.php', dados);
	}

</script>


		</section>
	</body>
</html>