<?php
	session_start();
	if (!isset($_SESSION["login"]) || !isset($_SESSION["senha"])) {
		header("Location: login.html");
		exit;
	}


	include('busca_banco/conexao.php');


	$login = $_SESSION["login"];

	$query = "SELECT * FROM cenarios WHERE permissao = 'pub' or id_user = (SELECT id FROM usuarios WHERE login = '$login')";
	$sql = mysqli_query($conexao, $query);


	function contar_maquinas($conexao, $id){
		$query = "SELECT id FROM maquina WHERE id_cenario = '$id'";
		$sql = mysqli_query($conexao, $query);
		$row = mysqli_num_rows($sql);
		return $row;
	}
	function butao($conexao, $id_cenario, $login) {
		$query = "SELECT * FROM containers WHERE id_cenario = $id_cenario AND id_usuario = (SELECT id FROM usuarios WHERE login = '$login')";
		$sql = mysqli_query($conexao, $query);
		$row = mysqli_num_rows($sql);

		if ($row == 0) {
			return "1"; //aparece botao
			}else{
				return "0"; //
			}
	}
	function permissao($permissao){
		if ($permissao == 'pub') {
			return "Público";
		}else{
			return "Privado";
		}
	}


	function pertence($conexao, $id_cenario, $login){
		$query = "SELECT * FROM cenarios WHERE id = $id_cenario AND id_user = (SELECT id FROM usuarios WHERE login = '$login')";

		$sql = mysqli_query($conexao, $query);

		$row = mysqli_num_rows($sql);

		if ($row == 0) {
			echo "Não";
		}else{
			echo "Sim";
		}

	}

?>

			


<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Tela de Cenários</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/estilo.css">

		<style type="text/css">
			.pointer {
				cursor: pointer;
			}

			.not-allowed {
				cursor: not-allowed;
			}
		</style>


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
				<h1 >Cenários:</h1>

			<div class="container">

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center"><h3>Nome do Cenário</h3></th>
									<th class="text-center"><h3>Permissão</h3></th>
									<th class="text-center"><h3>Dono</h3></th>
									<th class="text-center"><h3>Descrição do Cenário</h3></th>
									<th class="text-center"><h3>Situação</h3></th>
								</tr>
							</thead>

							<tbody>

<?php
	while($exibe = mysqli_fetch_assoc($sql)){
		$id = $exibe['id'];
		$nome = $exibe['nome_cenario'];
		$descricao = $exibe['descricao'];
//$nome = iconv( 'CP1252', 'UTF-8', $exibe['nome_cenario']);
//$descricao = iconv( 'CP1252', 'UTF-8', $exibe['descricao']);
		$num_de_maquinas = contar_maquinas($conexao, $id); 
		$caminho = $exibe['path'];
		$permissao = $exibe['permissao'];
		$id_usuario = $exibe['id_user'];

		$aa = butao($conexao, $id, $login);
?>

								<tr class=<?php if ($aa != 0) { echo "\"pointer\""; }else{ echo "\"not-allowed\"";} ?> onclick=<?php if ($aa != 0) {echo "\"submeter('form_$id')\"";}else{echo "\"alert('Cenário em uso')\"";}?>>
									<td class="text-center"><h4 title="<?php echo 'Numero do Containers: ' .$num_de_maquinas; ?>" ><?php echo $nome; ?></h4></td>
									<td class="text-center"><h5><?php echo permissao($permissao); ?></h5></td>
									<td class="text-center"><h5><?php pertence($conexao, $id, $login); ?></h5></td>
									<td class="text-center"><h5><?php echo $descricao; ?></h5></td>
									<td class="text-center">



<?php 
if (butao($conexao, $id, $login) != 0) {	
?>
										<form id=<?php echo "\"form_$id\""?> action="mostrar_script.php" method="post">
											<input type="hidden" name="id_cenario" value=<?php echo "\"$id\"";?>>
											
											<input type="hidden" name="nome_cenario" value=<?php echo "\"$nome\"";?>>

											<input type="hidden" name="descricao" value=<?php echo "\"$descricao\"";?>>

											<input type="hidden" name="permissao" value=<?php echo $permissao;?>>
											
											<input type="hidden" name="caminho" value=<?php echo $caminho;?>>
											
											<input type="hidden" name="pertence" value=<?php pertence($conexao, $id, $login); ?>>

<!--
											<input type="submit" class="btn btn-primary btn-lg" value="Iniciar Cénario">
-->
										</form>
<?php
	echo "<h5>Disponivel</h5>";
}else{
	echo "<h5>Cenário em Uso</h5>";
}


?>


									</td>
								</tr>
<?php
}
mysqli_close($conexao);
?>
							</tbody>
						</table>
					</div>	

				</div>

			</div>

		</section>
<script src="js/jquery.min.js"></script>
<script type="text/javascript">
	
	function submeter(id){
		document.getElementById(id).submit();
	}
</script>
	</body>
</html>