<?php
include('conexao.php');

$fazer = $_POST['fazer'];
$nome = $_POST['nome'];

switch ($fazer) {
	case 'trazerredes':
		$query = "SELECT * FROM redes";
		$sql = mysqli_query($conexao, $query);


		echo "<option value='padrao'>Padrão</option>\n";
		
		while($exibe = mysqli_fetch_assoc($sql)){
			$nome = $exibe['nome'];
			echo "<option value=$nome>$nome</option>\n";
		}
		
		break;

	case 'trazer':
		$query = "SELECT * FROM redes";
		$sql = mysqli_query($conexao, $query);


		while($exibe = mysqli_fetch_assoc($sql)){
			$nome = $exibe['nome'];
			$tipo = $exibe['tipo'];

			echo "
				<tr>
					<td> $nome</td>
					<td> $tipo</td>
				</tr>
			";
		}
		break;

	case 'consutar':
		$query = "SELECT * FROM `redes` WHERE `nome` LIKE '$nome'";
		$sql = mysqli_query($conexao, $query);

		$row = mysqli_num_rows($sql);

		echo "$row";

		break;

	case 'inserir':
		
		shell_exec("sudo docker network create -d bridge $nome");
		$query = "INSERT INTO `redes` (`id`, `nome`, `tipo`) VALUES (NULL, '$nome', 'bridge')";
		mysqli_query($conexao, $query);
		break;
}

mysqli_close($conexao);
?>