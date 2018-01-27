<?php 

	include 'conexao.php';

	$acao = $_POST['acao'];

	switch ($acao) {
	case 'getUsuarios':

	echo "<tr>
						      	<td>Mark</td>
						      	<td>Otto</td>
						      	<td><a href='#'>Atualizar</a> <a href='#'>Deletar</a></td>
						    </tr>";
		
		break;

	}



	mysqli_close($conexao);
?>