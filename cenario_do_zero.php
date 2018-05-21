<?php
	session_start();
	if (!isset($_SESSION["login"]) || !isset($_SESSION["senha"])) {
		header("Location: login.html");
		exit;
	}

	$login = $_SESSION["login"];
	$id_user = $_SESSION["id"];



	include('busca_banco/conexao.php');

	$query = "SELECT * FROM imagens";
	$sql = mysqli_query($conexao, $query);


	if ($_POST['id']) {
		$id_cenario = $_POST['id'];
		$query1 = "SELECT * FROM cenarios WHERE id = $id_cenario";
		$sql1 = mysqli_query($conexao, $query1);
		$exibe = mysqli_fetch_assoc($sql1);

		$path = $exibe['path'];
		$corpo = shell_exec("cat $path/miolo.txt");

		$query_nomes = "SELECT * FROM maquina WHERE id_cenario = $id_cenario";
	
		$sql_nomes = mysqli_query($conexao, $query_nomes);
		$nomes = "";
		while($exibe = mysqli_fetch_assoc($sql_nomes)){


			$nome = $exibe['nome'];
			$imagem = $exibe['imagem'];

			$nomes = $nomes ."-" .$nome ." " .$imagem;
		}
			
	}


	$nome_cenario = $_POST['nome'];
	$descricao = $_POST['descricao'];
	$permissao = $_POST['permissao'];
	//$corpo = $_POST['corpo'];

	$pertence = $_POST['pertence'];

	$id = $_POST['id'];

?>


<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<title>Criar Cenário</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/estilo.css">

		<script	type="text/javascript"	src="css/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

		<style type="text/css">
			fieldset {
				border: 1px solid #ddd !important;
				margin: 0;
				xmin-width: 0;
				padding: 10px;       
				position: relative;
				border-radius:4px;
				padding-left:10px!important;
			}	

			legend{
				font-size:14px;
				font-weight:bold;
				margin-bottom: 0px; 
				width: 35%; 
				border: 1px solid #ddd;
				border-radius: 4px; 
				padding: 5px 5px 5px 10px;
				background-color: #f5f5f5;
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
				<h1>Criar Cenário</h1>

				<div id="principal">
	            	<fieldset class="col-md-6 col-md-offset-3">    	
						<legend>Dados do Cenário</legend>
						<div class="panel-body text-center">
							
								<label for="nome">Nome do Cenário: </label><br>
								<input type="text" name="nome" id="nome" value=<?php echo "\"$nome_cenario\""; ?> autofocus>

				<br>
								<label for="descricao">Descrição do Cenário: </label>
				<br>
<textarea name="descricao" id="descricao" maxlength="1000" rows="3">
<?php echo "$descricao"; ?>
</textarea>
				<br>
								<label for="privacidade">Privadidade: </label><br>


								<input type="radio" name="privacidade" id="publico" value="pub" <?php if ($permissao == "pub") { echo "checked"; } else{ if (!isset($_POST['permissao'])) { echo "checked";}} ?>>
								<label for="publico">Público</label> 
									
								<input type="radio" name="privacidade" id="privado" value="priv" <?php if ($permissao == "priv") { echo "checked"; } ?>>
								<label for="privado">Privado</label>


								<br>
								<button type="button" id="criar" class="btn btn-success btn-sm">Próximo</button>
			                    <button type="reset" class="btn btn-default btn-sm">Limpar</button>
								<br>
						</div>
					</fieldset>
				</div>

				<div id="script" class="text-center" style="display: none;">


<!-- Modal add/del containers-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Contêiner</h4>
			</div>
			
			<div class="modal-body text-center">
			<table class="table">
				<thead>
					<tr>
						<th class="text-center">Nome</th>
						<th class="text-center">Imagem</th>
						<th class="text-center">Ação</th>
					</tr>
				</thead>

				<tbody id="lista_containers">
				</tbody>

			</table>
			</div>

<div class='panel-body text-center'>
	<form id="configform">
		<div id="Containers" style='border: 1px solid #ccc; display: none;'>
			
			<label for='nome_container'>Nome:</label><br>
			<input type='text' name='nome_container' id='nome_container' autofocus>
		<br>
			<label>Imagem:</label>
				<select id="imagem">
					<?php
						while($exibe = mysqli_fetch_assoc($sql)){
							$nome = $exibe['nome'];
							$versao = $exibe['versao'];
					?>
							<option value=<?php echo "$nome:$versao"; ?> title='texto explicativo'><?php echo "$nome:$versao"; ?></option>
					<?php } ?>

				</select>
		<br>

		<label>Rede Padrão:</label>
				<select id="rede">
				</select>

		<br>
			<label for='permissao'>Permissão:</label><br>
			<input type='radio' name='permissao' id="p1" checked value="1">Privilegiado
			<input type='radio' name='permissao' id="p2" value="0">Sem permissão
			<br>
			<button type='button' class='btn btn-success' id="add">Add</button>
			<button type="reset" class="btn btn-default btn-sm">Limpar</button>
		</div>
	</form>

</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="adicionar_container">Adicionar Contêiner</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Redes-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Redes</h4>
			</div>
			
			<div class="modal-body text-center">

				<table class="table">
					<thead>
						<tr>
							<th class="text-center">Nome</th>
							<th class="text-center">Tipo</th>
						</tr>
					</thead>

					<tbody id="lista_redes">
					</tbody>
				</table>

<div class='panel-body text-center'>
		<div id="Redes2" style='border: 1px solid #ccc;display: none;'>
			<label for='nome_rede'>Nome:</label><br>
			<input type='text' name='nome_rede' id='nome_rede'>
		<br>
			<button type='button' class='btn btn-success' id="add_rede">Add</button>
			<button type="reset" class="btn btn-default btn-sm">Limpar</button>
		</div>
</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="adicionar_rede">Adicionar Rede</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Cabecalho -->
<div class="modal fade" id="cabecalho" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Cabeçalho</h4>
			</div>
			
			<div class="modal-body text-center">

<textarea id="texto_cabecalho" rows="20" cols="65" disabled>
#!/bin/bash

clear

function ScriptConecta {
	sudo touch /home/$1/$2.sh
	sudo chown www-data:www-data /home/$1/$2.sh
	sudo chmod 705 /home/$1/$2.sh

	echo "#!/bin/bash" > /home/$1/$2.sh
	echo "clear" >> /home/$1/$2.sh
	echo "sudo docker exec -it $3 login" >> /home/$1/$2.sh
}
</textarea>

<textarea id="texto_cabecalho2" style="display: none">
#!/bin/bash

clear

function ScriptConecta {
	sudo touch /home/$1/$2.sh
	sudo chown www-data:www-data /home/$1/$2.sh
	sudo chmod 705 /home/$1/$2.sh

	echo "#!/bin/bash" > /home/$1/$2.sh
	echo "clear" >> /home/$1/$2.sh
	echo "sudo docker exec -it $3 login" >> /home/$1/$2.sh
}
</textarea>

			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<!-- Modal Ajuda-->
<div class="modal fade" id="help" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Ajuda</h4>
			</div>
			
			<div class="modal-body" style="text-align: left;">

<h3><b>Máquinas</b></h3>

	<li style="text-indent: 2em">Adicicionar Maquina</li>

		<p align="justify" style="margin-left: 75px;">Para adicionar uma máquina é necessário ir em <i>Contêiners</i> > <i>Adicionar Contêiner</i>, preencher o formulário com as informações necessárias, logo após clique em <i>Add</i> para adicionar.</p>

	<li style="text-indent: 2em">Remover Maquina</li>

		<p align="justify" style="margin-left: 75px;">Para deletar uma máquina é necessário ir em <i>Contêiners</i>, verificar qual máquina que deletar e clicar em <i>deletar</i>.</p>

<h3><b>Redes</b></h3>

	<li style="text-indent: 2em">Listar Redes</li>	
		<p align="justify" style="margin-left: 75px;">Para verificar as redes existentes clique no botão <i>Redes</i>.</p>

	<li style="text-indent: 2em">Adicionar um nova Rede</li>
		<p align="justify" style="margin-left: 75px;">Para adicionar uma nova rede vá em <i>redes</i> > <i>adicionar rede</i>, preencher o formulário e clicar em <i>add</i>.</p>

	<li style="text-indent: 2em">Associar Rede a uma máquina</li>
		<p align="justify" style="margin-left: 75px;">Para associar uma rede a uma máquina:</p>
		<p style="margin-left: 100px;"><i>sudo docker network connect &lt;rede&gt; &lt;máquina&gt;</i></p>

<h3><b>Comandos Úteis</b></h3>
	<li style="text-indent: 2em">Macarar pacotes por uma interface</li>
		<p style="margin-left: 75px;">
			<i>sudo iptables -I POSTROUTING -t nat -o eth0 -j MASQUERADE</i>
		</p>

	<li style="text-indent: 2em">Capturar IP da Gatewall de Uma rede</li>
		<p style="margin-left: 75px;"><i>IP=$(sudo docker inspect -f "{{ .NetworkSettings.Networks.&lt;Rede&gt;.Gateway }}" &lt;maquina&gt;)</i></p>

	<li style="text-indent: 2em">Capturar IP uma Maquina</li>
		<p style="margin-left: 75px;"><i>IP=$(sudo docker inspect -f "{{ .NetworkSettings.Networks.&lt;Rede&gt;.IPAddress }}" &lt;maquina&gt;)</i></p>

	<li style="text-indent: 2em">Remover Acesso a Rede</li>
		<p style="margin-left: 75px;"><i>sudo docker exec &lt;máquina&gt; route del default gw &lt;IPGatewall&gt;</i></p>

	<li style="text-indent: 2em">Adiconar nova rota</li>
		<p style="margin-left: 75px;"><i>sudo docker exec &lt;máquina&gt; route add default gw &lt;ipServidor&gt; eth0</i></p>

			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<!-- Modal salva-->
<div class="modal fade" id="salva" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Dados do Cenário</h4>
			</div>
			
			<div class="modal-body text-center">
				

<form method="post">
	<label for="nome">Nome do Cenário: </label><br>
	<input type="text" name="nome" id="nome_salva" onkeypress="atualizar('nome', 'nome_salva')" autofocus="">

<br>
	<label for="descricao">Descrição do Cenário: </label>
<br>
<textarea name="descricao" id="descricao_salva" maxlength="1000" rows="3" onkeypress="atualizar('descricao', 'descricao_salva')">
</textarea>
<br>
	<label for="privacidade">Privadidade: </label><br>

	<input type="radio" name="privacidade" id="publico_salva" onclick="atualizar_privacidade('publico')" value="pub" checked>
	<label for="publico" title="Esse opção torna o cenário publico, disponível para todos os usuários, uma vez selecionado não é possivel altera-la">Público</label> 
		
	<input type="radio" name="privacidade" id="privado_salva" onclick="atualizar_privacidade('privado')" value="priv">
	<label for="privado" title="Esse opção torna o cenário privado, disponível apenas para o seu usuário, uma vez selecionado não é possivel altera-la">Privado</label>

</form>


<div class="modal-body text-center">
<table class="table">
	<thead>
		<tr>
			<th class="text-center">Nome</th>
			<th class="text-center">Imagem</th>
		</tr>
	</thead>

	<tbody id="lista_containers2">

	</tbody>

</table>

</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-success btn-sm" id="salva_final">Salvar</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>







<div class="modal fade" id="confimacao" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h5 class="modal-title" id="exampleModalLongTitle"><h2>Importante!</h2></h5>
			</div>
			<div class="modal-body">
				<p>Deseja fazer uma cópia ou salvar</p>
				<p><i>Obs.: Ao clicar em "Salvar" será salva as alterações no cenário selecionado, ao clicar em "Copiar" será salvo em um novo cenário.</i></p>
			</div>
		<div class="modal-footer">
		<div class="text-center">
		<button class="btn btn-primary" onclick="acao('copiar')">Copiar</button>
		<button class="btn btn-primary" onclick="acao('salvar')">Salvar</button>
		</div>
		</div>
		</div>
	</div>
</div>


					<button type="button" id="container" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal">Contêiner</button>

					<button type="button" id="rede" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal2">Redes</button>
					<br>
					<h2 data-toggle="modal" data-target="#cabecalho">Script</h2>
<textarea id="textoaria" rows="14" cols="100">
<?php if (isset($_POST['corpo'])) {
	echo "$corpo";
} ?>
</textarea>

<br>
					<button type="button" id="voltar" class="btn btn-default btn-sm">Voltar</button>
					<button type="button" id="ajuda" class="btn btn-default btn-sm" data-toggle="modal" data-target="#help">Ajuda</button>

					<br>
					<button type="button" id="Salvar" class="btn btn-default btn-sm" data-toggle="modal" data-target="#salva">Salvar Cenário</button>
					<br><br>
					<br><br>

				</div>

		</section>



	<input type="hidden" id="id" value=<?php echo $id; ?>>
	<input type="hidden" id="login" value=<?php echo $login; ?>>
	<input type="hidden" id="nomes" value=<?php echo "\"$nomes\""; ?>>
	<input type="hidden" id="pertence" value=<?php echo $pertence;?>>
	<input type="hidden" id="id_user" value=<?php echo $id_user;?>>
	<input type="hidden" id="id_cenario" value=<?php echo $id_cenario;?>>

	<form id="form_final" action="matriculas.php" method="POST">
		<input type="hidden" name="login" value=<?php echo $login; ?>>
		<input type="hidden" id="id_ce" name="id_ce">
		<input type="hidden" id="caminho" name="caminho">
	</form>
	<script src="js/criar_cenario.js"></script>
	</body>
</html>
