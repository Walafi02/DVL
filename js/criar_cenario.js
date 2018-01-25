var cenarios = [];

var nomes = document.getElementById('nomes');


var nomes_divididos = nomes.value.split("-");

var cont = 2;
for (var i in nomes_divididos) { 
	if ( nomes_divididos[i] != "" ) {
		nomes2 = nomes_divididos[i].split(" ");
		
		if (nomes2[0] != "<br"){
			

		cenarios.push({nome: nomes2[0], imagem: nomes2[1]})
		document.getElementById("texto_cabecalho").value += "\n" + nomes2[0] + "=\$1-\$2-\$" + cont + "-\"" + nomes2[0] + "\"";
	}	cont++;
}
}

texto();

//ação do butão voltar
$('#voltar').click(function(){
	$('#principal').css("display", "block");
	$('#script').css("display", "none");
});

$('#criar').click(function(){
	var nome = document.getElementById('nome').value;
	var descricao = document.getElementById('descricao').value;

	if (nome == "") {
		alert('Preencha o campo Nome');
		$('#nome').focus();
		return false;
		}else if (descricao == ""){
			alert('Preencha o campo Descrição');
			$('#descricao').focus();
			return false;
			}else{
				$('#principal').css("display", "none");
				$('#script').css("display", "block");
				return true;
			}
});

$('#adicionar_container').click(function(){
	if($('#Containers').css('display') == 'none'){ 
			$('#configform')[0].reset();
			$('#Containers').css("display", "block");
	} else { 
	    $('#Containers').css("display", "none");
	}
	
});

var aa = 0;
$('#add').click(function(){
	var nome_container = document.getElementById('nome_container').value;
	var imagem = document.getElementById('imagem').value;
	var rede = document.getElementById('rede').value;

	if (rede == 'padrao') {
		var redeconnect = "";
	}else{
		var redeconnect = " --net " + rede; 
	}

	aa = 0;
	for (var i=0; i < cenarios.length; i++){
		if (nome_container == cenarios[i].nome) {
			aa = 1;
		}
	}



	if (document.getElementById('p1').checked) {
		var permissao = "--privileged";

	}else{
		var permissao = "";
	}

	if (nome_container == "") {
		alert('Preencha o campo Nome');
		$('#nome_container').focus();
		return false;
	}else if (aa == 1) {
		alert('Nome já exitente, Preencha o campo Nome com um nome diferente!!!');
		$('#nome_container').val('');
		$('#nome_container').focus();
		return false;
	}else{
		cenarios.push({nome: nome_container, imagem: imagem})
		$('#Containers').css("display", "none");
		texto()

		document.getElementById("textoaria").value += "\nsudo docker run -itd "+ permissao + " --name $" + nome_container +" -h $" + nome_container + redeconnect + " " + imagem + "\n";
		document.getElementById("texto_cabecalho").value += "\n" + nome_container + "=\$1-\$2-\$" + cont + "-\"" + nome_container + "\"";

		return true;
	}
});



function del(id, nome){
	cenarios.splice(id, 1);

	var login = document.getElementById('login').value;
	var text = document.getElementById("textoaria").value;
	dados = {
			nome: nome,
			dados: text,
			login: login,
			acao: '1'
		}

	$.post('busca_banco/deletar.php', dados, function(retorna){
				document.getElementById("textoaria").value = retorna;
			});


	var text = document.getElementById("texto_cabecalho").value;
	dados = {
			nome: nome,
			dados: text,
			login: login,
			acao: '2'
		}

	$.post('busca_banco/deletar.php', dados, function(retorna){
				document.getElementById("texto_cabecalho").value = retorna;
			});

	texto()
};

function texto(){
	var text = '';
	for (var i=0; i < cenarios.length; i++){
	text += "\
			<tr>\
				<td>" + cenarios[i].nome+ "</td>\
				<td>" +cenarios[i].imagem + "</td>\
				<td><button type='button' class='btn btn-danger' onclick='del("+ i +", \"" + cenarios[i].nome + "\")'>deletar</button></td>\
			</tr>"
	}

	$("#lista_containers").html(text);

}

$('#Salvar').click(function(){
	texto2()

	var nome = document.getElementById('nome').value;
	var descricao = document.getElementById('descricao').value;

	document.getElementById('nome_salva').value = nome;
	document.getElementById('descricao_salva').value = descricao;
	
	if (document.getElementById("publico").checked) {
		document.getElementById("publico_salva").checked = true;
	}else{
		document.getElementById("privado_salva").checked = true;
		
	}


});

function atualizar(n1, n2){
	var valor = document.getElementById(n2).value;

	document.getElementById(n1).value = valor;
}

function atualizar_privacidade(){
	if (document.getElementById("publico_salva").checked) {
		document.getElementById("publico")[0].checked = true;
	}else{
		document.getElementById("privado").checked = true;
		
	}

}

function texto2(){
	var text = '';
	for (var i=0; i < cenarios.length; i++){
	text += "\
			<tr>\
				<td>" + cenarios[i].nome+ "</td>\
				<td>" +cenarios[i].imagem + "</td>\
			</tr>"
	}

	$("#lista_containers2").html(text);

}


$('#salva_final').click(function(){

	aa = 0;
	for (var i=0; i < cenarios.length; i++){
		aa++;
	}

	if (aa == 0) {
		alert("É necessario Adicionar pelo menos uma Máquina");
		$('#salva').modal('hide'); 
		$('#myModal').modal('show');
		$('#configform')[0].reset();
		$('#Containers').css("display", "block");
		$('#nome_container').focus();
		return false;
	}else{
		var nome = document.getElementById('nome_salva').value;
		var descricao = document.getElementById('descricao_salva').value;
		var pertence = document.getElementById('pertence').value;

		if (nome == "") {
			alert('Preencha o campo Nome');
			$('#nome_salva').focus();
			return false;
			}else if (descricao == ""){
				alert('Preencha o campo Descrição');
				$('#descricao_salva').focus();
				return false;
				}else if (pertence == "Sim") { //verifica se não é dono
					$('#confimacao').modal('show');
				}else{
					var id_user = document.getElementById('id_user').value;
					var pertence = document.getElementById('id_user').value;
					var cabecalho = document.getElementById('texto_cabecalho2').value;
					var textoaria = document.getElementById('textoaria').value;


					if (document.getElementById('publico_salva').checked) {
						var privacidade = "pub";
					}else{
						var privacidade = "priv";
					}
					var conexao = "";
					var nomes_maquinas = "";
					for (var i=0; i < cenarios.length; i++){		
						conexao += "ScriptConecta \$2 Conecta\$" + cenarios[i].nome + " \$" + cenarios[i].nome + "\n";
						nomes_maquinas += cenarios[i].nome + "-" + cenarios[i].imagem + " ";
					}

					dados = {
						acao: 'copiar',
						id_user: id_user,
						id_cenario: 'nulo',
						nome: nome,
						descricao: descricao,
						privacidade: privacidade,
						cabecalho: "\'" + cabecalho + "\'",
						textoaria: "\'" + textoaria + "\'",
						conexao: conexao,
						pertence: pertence,
						nomes_maquinas: nomes_maquinas
					}

					$.post("busca_banco/altera_cenario.php", dados, function(retorna){
						var retorno = retorna.split("-");

						document.getElementById('caminho').value = retorno[0];
						document.getElementById('id_ce').value = retorno[1];

						document.getElementById("form_final").submit();
					});


				}
	}




});



function acao(fazer){
	var nome = document.getElementById('nome_salva').value;
	var descricao = document.getElementById('descricao_salva').value;
	var pertence = document.getElementById('pertence').value;
	var id_user = document.getElementById('id_user').value;
	var pertence = document.getElementById('id_user').value;
	var cabecalho = document.getElementById('texto_cabecalho2').value;
	var textoaria = document.getElementById('textoaria').value;

	var id_cenario = document.getElementById('id_cenario').value;


	if (document.getElementById('publico_salva').checked) {
		var privacidade = "pub";
	}else{
		var privacidade = "priv";
	}
	var conexao = "";
	var nomes_maquinas = "";
	for (var i=0; i < cenarios.length; i++){		
		conexao += "ScriptConecta \$2 Conecta\$" + cenarios[i].nome + " \$" + cenarios[i].nome + "\n";
		nomes_maquinas += cenarios[i].nome + "-" + cenarios[i].imagem + " ";
	}

	dados = {
		acao: fazer,
		id_user: id_user,
		id_cenario: id_cenario,
		nome: nome,
		descricao: descricao,
		privacidade: privacidade,
		cabecalho: "\'" + cabecalho + "\'",
		textoaria: "\'" + textoaria + "\'",
		conexao: conexao,
		pertence: pertence,
		nomes_maquinas: nomes_maquinas
	}

	$.post("busca_banco/altera_cenario.php", dados, function(retorna){
		var retorno = retorna.split("-");

		document.getElementById('caminho').value = retorno[0];
		document.getElementById('id_ce').value = retorno[1];

		document.getElementById("form_final").submit();
	});
}


function busca_redes(){
	dados = {
		fazer: 'trazer'
	}
	$.post("busca_banco/redes.php", dados, function(retorna){
		$("#lista_redes").html(retorna);
	});

	dados = {
		fazer: 'trazerredes'
	}
	$.post("busca_banco/redes.php", dados, function(retorna){
		$("#rede").html(retorna);
	});
}

busca_redes()


$('#adicionar_rede').click(function(){
	if ($('#Redes2').css('display') == 'none') {
		$('#Redes2').css("display", "block");
	}else{
		$('#Redes2').css("display", "none");
	}
});

$('#add_rede').click(function(){
	var nome_rede = document.getElementById('nome_rede').value;

	if (nome_rede == "") {
		alert("É necessário adicionar um nome");
	}else {
		dados = {
			fazer: 'consutar',
			nome: nome_rede
		}
		$.post("busca_banco/redes.php", dados, function(retorna){
			if (retorna > 0) {
				alert("Nome já em uso, escolha outro nome.");
				$('#nome_rede').val('');
				$('#nome_rede').focus();
			}else{
				dados = {
					fazer: 'inserir',
					nome: nome_rede
				}
				$.post("busca_banco/redes.php", dados, function(retorna){
					busca_redes()
					$('#Redes2').css("display", "none");
				});
			}

		});


	}
});


//bloqueia a submisão de formulario com o enter
$(document).ready(function () {
   $('input').keypress(function (e) {
        var code = null;
        code = (e.keyCode ? e.keyCode : e.which);                
        return (code == 13) ? false : true;
   });
});
