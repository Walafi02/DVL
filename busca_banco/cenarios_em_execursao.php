<?php
	include 'conexao.php';

	$login = $_POST['login'];


	$query = "SELECT id_cenario FROM containers WHERE id_usuario = (SELECT id FROM usuarios WHERE login = '$login') GROUP BY id_cenario";

	$sql = mysqli_query($conexao, $query);


	while($exibe = mysqli_fetch_assoc($sql)){
		$id = $exibe['id_cenario'];

		$query_cenario = "SELECT * FROM cenarios WHERE id = '$id'";
		$sql_cenarios = mysqli_query($conexao, $query_cenario);
		$exibe2 = mysqli_fetch_assoc($sql_cenarios);
		$nome = $exibe2['nome_cenario'];
//$nome = iconv( 'CP1252', 'UTF-8', $exibe2['nome_cenario']);


		$query_ce = "SELECT estado FROM containers WHERE id_cenario = '$id' AND id_usuario = (SELECT id FROM usuarios WHERE login = '$login')";
		$sql_ce = mysqli_query($conexao, $query_ce);


		echo "<tr class='text-center'>
					<td>$nome</td>
					<td>";


	$estado0 = 0;
	$estado1 = 0;
	$estado2 = 0;
	$estado3 = 0;
	$estado4 = 0;
	$estado5 = 0;
	$estado6 = 0;

	while ($exibe3 = mysqli_fetch_assoc($sql_ce)){
		$estado = $exibe3['estado'];
		
		switch ($estado) {
			case 0:
				$estado0++;
				break;
		
			case 1:
				$estado1++;
				break;

			case 2:
				$estado2++;
				break;

			case 3:
				$estado3++;
				break;

			case 4:
				$estado4++;
				break;

			case 5:
				$estado5++;
				break;

			case 6:
				$estado6++;
				break;

		}

	}





	$cont = 0;
	if ($estado0 > 0) {
		if ($cont == 1) {
			echo " | ";
		}
		echo "<span style=''>Iniciando: </span>$estado0";
		$cont = 1;
		}
	
	if ($estado1 > 0) {
		if ($cont == 1) {
			echo " | ";
			}
		echo "<span style='color: #008000;'>Running:</span> $estado1";
		$cont = 1;
		}
	
	if ($estado2 > 0) {
		if ($cont == 1) {
				echo " | ";
			}
		echo "<span style=''>Executando Start:</span> $estado2";
		$cont = 1;
		}

	if ($estado3 > 0) {
		if ($cont == 1) {
			echo " | ";
			}
		echo "<span style=''>Executando Stop:</span> $estado3";
		$cont = 1;
		}

	if ($estado4 > 0) {
		if ($cont == 1) {
			echo " | ";
			}
		echo "<span style='color: #D2691E;'>Stop:</span> $estado4";
		$cont = 1;
		}

	if ($estado5 > 0) {
		if ($cont == 1) {
			echo " | ";
			}
		echo "<span style=''>Deletando:</span> $estado5";
		}

	if ($estado6 > 0) {
		if ($cont == 1) {
			echo " | ";
			}
		echo "<span style='color: red;'>Erro:</span> $estado6";
		$cont = 1;
		
		}	


echo "</td>
	<td>";



	if ($estado0 > 0 or $estado2 > 0 or $estado3 > 0 or $estado5 > 0) {
		echo "Aguarde";
	}else{
		if ($estado1 > 0) {
			echo "<button class='btn btn-warning' onclick=\"tratar_cenario('stop', '$id')\">Stop</button>";
		}
		if ($estado4 > 0) {
			echo "<button class='btn btn-success' onclick=\"tratar_cenario('startar', '$id')\">Startar</button>";
		}
		if ($estado6 > 0) {
			echo "<button class='btn btn-info' onclick=\"tratar_cenario('restartar', '$id')\">Restartar</button>";
		}

		echo "<button class='btn btn-danger' onclick=\"tratar_cenario('deletar', '$id')\">Deletar</button>";
	}






echo "</td>
			</tr>";





































}





/*

$cont = 0;
$running = 0;
$stop = 0;
$erro = 0;
while ($exibe3 = mysqli_fetch_assoc($sql_ce)){
		$estado = $exibe3['estado'];


if ($estado == 0) {
	if ($cont == 1) {
		echo " | ";
	}
	echo "<span style=''>Iniciando</span>";
	$cont = 1;
	}elseif ($estado == 1) {
		if ($cont == 1) {
			echo " | ";
			}
		echo "<span style='color: #008000;'>Running</span>";
		$cont = 1;
		$running = 1;
		}elseif ($estado == 2) {
			if ($cont == 1) {
				echo " | ";
			}
			echo "<span style=''>Executando Start</span>";
			$cont = 1;
			}elseif ($estado == 3) {
				if ($cont == 1) {
					echo " | ";
				}
				echo "<span style=''>Executando Stop</span>";
				$cont = 1;
				}elseif ($estado == 4) {
					if ($cont == 1) {
						echo " | ";
					}
					echo "<span style='color: #D2691E;'>Stop</span>";
					$cont = 1;
					$stop = 1;
					}elseif ($estado == 5) {
						if ($cont == 1) {
							echo " | ";
							}
						echo "<span style=''>Deletando</span>";
						}elseif ($estado == 6) {
							if ($cont == 1) {
								echo " | ";
								}
							echo "<span style='color: red;'>Erro</span>";
							$cont = 1;
							$erro = 1;
							}	

}

	echo "</td>
	<td>";
	if ($erro == 1) {
		echo "<button class='btn btn-info' onclick=\"tratar_cenario('restartar', '$id')\">Restartar</button><button class='btn btn-danger' onclick=\"tratar_cenario('deletar', '$id')\">Deletar</button>";
	}elseif ($stop == 1) {
		echo "<button class='btn btn-success' onclick=\"tratar_cenario('startar', '$id')\">Startar</button><button class='btn btn-danger' onclick=\"tratar_cenario('deletar', '$id')\">Deletar</button>";		
	}elseif ($running == 1) {
		$aa = 1;
		echo "<button class='btn btn-warning' onclick=\"tratar_cenario('stop', '$id')\">Stop</button><button class='btn btn-danger' onclick=\"tratar_cenario('deletar', '$id')\">Deletar</button>";
	}else{
		echo "Aguarde";
	}

	echo "</td>
			</tr>";

}
*/
	mysqli_close($conexao);
?>
