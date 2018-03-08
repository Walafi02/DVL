<?php 

	include 'conexao.php';

	$acao = $_POST['acao'];

	switch ($acao) {
		case 'getUsuarios':
			$sql = "SELECT * FROM usuarios WHERE id != 1";
			$query = mysqli_query($conexao, $sql);
			while($exibe = mysqli_fetch_assoc($query)){
				$id = $exibe['id'];
				$nome = $exibe['login'];
				$tipo = $exibe['tipo'];
				echo "	<tr>
				      		<td>$nome</td>
				      		<td>$tipo</td>
				    	</tr>";
			}
		break;

		case 'addUsuario':
			$nome = $_POST['nome'];
			$tipo = $_POST['tipo'];
			$senha = md5($_POST['senha']);
			
			$sql = "SELECT * FROM usuarios WHERE login = '$nome'";
			$query = mysqli_query($conexao, $sql);
			$row = mysqli_num_rows($query);

			if ($row == 0) {
				$sql = "INSERT INTO `usuarios` (`id`, `tipo`, `login`, `senha`) VALUES (NULL, '$tipo', '$nome', '$senha')";
				mysqli_query($conexao, $sql);
			}else {
				echo $row;
			}



			break;
	}



	mysqli_close($conexao);
?>