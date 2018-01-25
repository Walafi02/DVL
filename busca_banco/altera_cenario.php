<?php
	$acao = $_POST['acao'];

	$id_user = $_POST['id_user'];
	$id_cenario = $_POST['id_cenario'];
	$nome = $_POST['nome'];
	$descricao = $_POST['descricao'];
	$privacidade = $_POST['privacidade'];
	$cabecalho = $_POST['cabecalho'];
	$textoaria = $_POST['textoaria'];
	$conexoes = $_POST['conexao'];
	$pertence = $_POST['pertence'];

	$nomes_maquinas = $_POST['nomes_maquinas'];
include('conexao.php');

if ($acao == "salvar") {

	$query = "UPDATE `cenarios` SET `nome_cenario` = '$nome', `descricao` = '$descricao', `permissao` = '$privacidade' WHERE `cenarios`.`id` = $id_cenario";
	mysqli_query($conexao, $query);

	$query = "SELECT * FROM cenarios WHERE id = $id_cenario";
	$sql = mysqli_query($conexao, $query);
	$exibe = mysqli_fetch_assoc($sql);
	$caminho = $exibe['path'];

	shell_exec("echo $cabecalho > ../$caminho/inicio.txt");
	shell_exec("echo $textoaria > ../$caminho/miolo.txt");

	$query_delata = "DELETE FROM `maquina` WHERE `id_cenario` = $id_cenario";
	mysqli_query($conexao, $query_delata);

	$cont = 3;
	$pieces = explode(" ", $nomes_maquinas);
	shell_exec("echo -n > ../$caminho/final.txt");
	foreach ($pieces as &$value) {
		if ($value != "") {

			$nomemaq = explode("-", $value);
			shell_exec("echo '$nomemaq[0]=\$1-\$2-\$$cont-\"$nomemaq[0]\"' >> ../$caminho/inicio.txt");
			$cont = $cont + 1;

			shell_exec("echo 'ScriptConecta \$2 Conecta\$$nomemaq[0] \$$nomemaq[0] \n' >> ../$caminho/final.txt");

			$query = "INSERT INTO `maquina` (`id`, `id_cenario`, `nome`, `imagem`) VALUES (NULL, '$id_cenario', '$nomemaq[0]', '$nomemaq[1]')";
			mysqli_query($conexao, $query);
		}
	}
	shell_exec("cat ../$caminho/inicio.txt > ../$caminho/script.sh");
	shell_exec("cat ../$caminho/miolo.txt >> ../$caminho/script.sh");
	shell_exec("cat ../$caminho/final.txt >> ../$caminho/script.sh");
	shell_exec("chmod 764 ../cenarios/cenario$num/script.sh");

	echo $caminho ."-$id_cenario";

}else{//copiar
	$result = mysqli_query($conexao, "SELECT MAX(id) FROM cenarios");
	$row = mysqli_fetch_array($result);
	$num = $row['MAX(id)'] + 1;

	$query = "INSERT INTO `cenarios` (`id`, `nome_cenario`, `id_user`, `permissao`, `descricao`, `path`) VALUES ('$num', '$nome', '$id_user', '$privacidade', '$descricao', 'cenarios/cenario$num')";
	mysqli_query($conexao, $query);


	shell_exec("mkdir -p ../cenarios/cenario$num");
	shell_exec("echo $cabecalho > ../cenarios/cenario$num/inicio.txt");
	shell_exec("echo $textoaria > ../cenarios/cenario$num/miolo.txt");

	$cont = 3;
	$pieces = explode(" ", $nomes_maquinas);
	shell_exec("echo -n > ../cenarios/cenario$num/final.txt");
	foreach ($pieces as &$value) {
		if ($value != "") {

			$nomemaq = explode("-", $value);
			shell_exec("echo '$nomemaq[0]=\$1-\$2-\$$cont-\"$nomemaq[0]\"' >> ../cenarios/cenario$num/inicio.txt");
			$cont = $cont + 1;

			shell_exec("echo 'ScriptConecta \$2 Conecta\$$nomemaq[0] \$$nomemaq[0] \n' >> ../cenarios/cenario$num/final.txt");

			$query = "INSERT INTO `maquina` (`id`, `id_cenario`, `nome`, `imagem`) VALUES (NULL, '$num', '$nomemaq[0]', '$nomemaq[1]')";
			mysqli_query($conexao, $query);

		}
	}
	shell_exec("cat ../cenarios/cenario$num/inicio.txt > ../cenarios/cenario$num/script.sh");
	shell_exec("cat ../cenarios/cenario$num/miolo.txt >> ../cenarios/cenario$num/script.sh");
	shell_exec("cat ../cenarios/cenario$num/final.txt >> ../cenarios/cenario$num/script.sh");

	shell_exec("chmod 764 ../cenarios/cenario$num/script.sh");

	echo "cenarios/cenario$num-$num";
}

?>