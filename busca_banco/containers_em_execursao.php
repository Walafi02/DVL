<?php
//	$login = "root";
	$login = $_POST['login'];
	include 'conexao.php';

	$query_cenario = "SELECT id_cenario FROM containers WHERE id_usuario = (SELECT id FROM usuarios WHERE login = '$login') GROUP BY id_cenario";	
	$sql_cenario = mysqli_query($conexao, $query_cenario);

	while ($exibe_cenario = mysqli_fetch_assoc($sql_cenario)) {
		$id_cenario = $exibe_cenario['id_cenario'];

		$query_nome_cenario = "SELECT nome_cenario FROM cenarios WHERE id = '$id_cenario'";
		$sql_nome_cenario = mysqli_query($conexao, $query_nome_cenario);
		$exibe_nome_cenario = mysqli_fetch_assoc($sql_nome_cenario);
		$nome_cenario = $exibe_nome_cenario['nome_cenario'];
//$nome_cenario = iconv( 'CP1252', 'UTF-8', $exibe_nome_cenario['nome_cenario']);

echo "
<thead>
<tr>
	<th colspan='2' class='text-center' style='background: #DCDCDC;'>
		<h3>Cenário: $nome_cenario</h3>
		<button type='button' class='btn btn-success' onclick=\"add_user('$id_cenario')\" id='myBtn'>Adicionar Aluno</button>
	</th>
</tr>
</thead>
";

		$query_matriculas = "SELECT matricula FROM containers WHERE id_usuario = (SELECT id FROM usuarios WHERE login = '$login') AND id_cenario = '$id_cenario' GROUP BY matricula";
		$sql_matriculas = mysqli_query($conexao, $query_matriculas);
		while ($exibe_matriculas = mysqli_fetch_assoc($sql_matriculas)) {
			$matricula = $exibe_matriculas['matricula'];

echo "
<thead>
<tr>
	<th colspan='2' class='text-center'>
		<h4>Aluno: $matricula</h4>
		
	</th>
</tr>

<tr>
	<th class='text-center'>Nome do Container</th>
	<th class='text-center'>Estado</th>
</tr>
</thead>

<tbody class='text-center'>
";


			$estado0 = 0;
			$estado1 = 0;
			$estado2 = 0;
			$estado3 = 0;
			$estado4 = 0;
			$estado5 = 0;
			$estado6 = 0;

			$query_container = "SELECT nome FROM containers WHERE id_usuario = (SELECT id FROM usuarios WHERE login = '$login') AND matricula = '$matricula' AND id_cenario = '$id_cenario'";
			$sql_container = mysqli_query($conexao, $query_container);
			while ($exibe_container = mysqli_fetch_assoc($sql_container)) {
				$nome = $exibe_container['nome'];

				$query_estado = "SELECT estado FROM containers WHERE id_usuario = (SELECT id FROM usuarios WHERE login = '$login') AND nome = '$nome'";
				$sql_estado = mysqli_query($conexao, $query_estado);
				$exibe_estado = mysqli_fetch_assoc($sql_estado);
				$estado = $exibe_estado['estado'];

echo "
<tr>
	<td>$nome</td>
	<td>
";

				switch ($estado) {
					case 0:
						echo "<span style=''>Iniciando</span>";
						$estado0++;
						break;
				
					case 1:
						echo "<span style='color: #008000;'>Running</span>";
						$estado1++;
						break;

					case 2:
						echo "<span style=''>Executando Start</span>";
						$estado2++;
						break;

					case 3:
						echo "<span style=''>Executando Stop</span>";
						$estado3++;
						break;

					case 4:
						echo "<span style='color: #D2691E;'>Stop</span>";
						$estado4++;
						break;

					case 5:
						echo "<span style=''>Deletando</span>";
						$estado5++;
						break;

					case 6:
						echo "<span style='color: red;'>Erro</span>";
						$estado6++;
						break;

				}

echo "
</td>
</tr>
";

			}

	$esperar = 0;
	if ($estado0 > 0) {
		$esperar = 1;
	}elseif ($estado2 > 0) {
		$esperar = 1;
	}elseif ($estado3 > 0) {
		$esperar = 1;
	}elseif ($estado5 > 0) {
		$esperar = 1;
	}

echo "
<tr>
	<td colspan='2'>
";

	if ($esperar != 1) {
		if ($estado1 > 0 and $estado6 == 0) {
			echo "<button class='btn btn-warning' onclick=\"tratar_container('stop', '$id_cenario', '$matricula')\">Stop</button>";
		}
		if ($estado4 > 0 and $estado6 == 0) {
			echo "<button class='btn btn-success' onclick=\"tratar_container('startar', '$id_cenario', '$matricula')\">Startar</button>";
		}
		if ($estado6 > 0) {
			echo "<button class='btn btn-info' onclick=\"tratar_container('restartar', '$id_cenario', '$matricula')\">Restartar</button>";
		}

		echo "<button class='btn btn-danger' onclick=\"tratar_container('deletar', '$id_cenario', '$matricula')\">Deletar</button>";
	}

echo "	</td>
</tr>
</tbody>
";
		}
	}
	mysqli_close($conexao);
?>