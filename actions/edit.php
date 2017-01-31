<?php

/* Trecho Responsável pela edição de um Chip no Banco de Dados */

if(!empty($_POST['hiddenChip'])) {
	$sql = "UPDATE relatorios_chips SET
	numero = '".$_POST['inputNumero']."', 
	situacao = '".$_POST['inputSituacao']."', 
	normal = '".$_POST['inputNormal']."', 
	micro = '".$_POST['inputMicro']."', 
	nano = '".$_POST['inputNano']."', 
	id_linha = '".$_POST['inputLinha']."',
	operadora = '".$_POST['inputOperadora']."',
	email = '".$_POST['inputEmail']."',
	senha = '".$_POST['inputSenha']."'
	WHERE id=".$_POST['hiddenChip'];
	$res = sqlsrv_query($con, $sql);

	$sql1 = "INSERT INTO relatorios_historico (nome, hora, descricao, id_usuario, sistema, id_item) VALUES ('Chip Editado', '".date("Y-m-d H:i:s")."', 'O Chip ".$_POST['hiddenChip']." foi Editado com Sucesso.', '".$_SESSION['userId']."', '2', '".$_POST['hiddenChip']."')";
	$res1= sqlsrv_query($con, $sql1);

	//echo "AQUI: ".$sql1;

	$resultado = "Chip Alterado com Sucesso!";
	echo '<script type="text/JavaScript"> setTimeout(function(){ window.location = ""; } , 2000); </script>'; 
}

/* Trecho Responsável pela edição de uma Linha no Banco de Dados */

if(!empty($_POST['hiddenLinha'])) {
	$sql = "UPDATE relatorios_linhas SET numero = '".$_POST['inputNumero']."', situacao = '".$_POST['inputSituacao']."', matricula = '".$_POST['inputMatriculaUsuario']."', nomeUsuario = '".$_POST['inputUsuario']."', cota = '".$_POST['inputCota']."', status = '".$_POST['inputStatus']."' WHERE id=".$_POST['hiddenLinha'];
	$res = sqlsrv_query($con, $sql);

	$sql1 = "INSERT INTO relatorios_historico (nome, hora, descricao, id_usuario, sistema, id_item) VALUES ('Linha Editada', '".date("Y-m-d H:i:s")."', 'A Linha ".$_POST['hiddenLinha']." foi Editada com Sucesso.', '".$_SESSION['userId']."', '2', '".$_POST['hiddenLinha']."')";
	$res1= sqlsrv_query($con, $sql1);

	//echo "AQUI: ".$sql1;

	$resultado = "Linha Alterada com Sucesso!";
	echo '<script type="text/JavaScript"> setTimeout(function(){ window.location = ""; } , 2000); </script>'; 
}



/* Trecho Responsável pela edição de um Modem no Banco de Dados */

if(!empty($_POST['hiddenModem'])) {
	$sql = "UPDATE relatorios_modens SET operadora = '".$_POST['inputOperadora']."', imei = '".$_POST['inputImei']."', situacao = '".$_POST['inputSituacao']."', usuario = '".$_POST['inputUsuario']."', matricula = '".$_POST['inputMatriculaUsuario']."', setor = '".$_POST['inputSetor']."', unidade = '".$_POST['inputUnidade']."', id_chip = '".$_POST['inputChip']."' WHERE id=".$_POST['hiddenModem'];
	$res = sqlsrv_query($con, $sql);

	$sql1 = "INSERT INTO relatorios_historico (nome, hora, descricao, id_usuario, sistema, id_item) VALUES ('Modem Editado', '".date("Y-m-d H:i:s")."', 'O Modem ".$_POST['hiddenModem']." foi Editado com Sucesso.', '".$_SESSION['userId']."', '2', '".$_POST['hiddenModem']."')";
	$res1= sqlsrv_query($con, $sql1);

	//echo "AQUI: ".$sql1;

	$resultado = "Modem Alterado com Sucesso!";
	echo '<script type="text/JavaScript"> setTimeout(function(){ window.location = ""; } , 2000); </script>'; 
}



/* Trecho Responsável pela edição de um Aparelho no Banco de Dados */


if(!empty($_POST['hiddenAparelho'])) {
	$sql = "UPDATE relatorios_telefones SET
		marca = '".$_POST['inputMarca']."',
		modelo = '".$_POST['inputModelo']."',
		imei = '".$_POST['inputImei']."',
		pin = '".$_POST['inputPin']."',
		situacao = '".$_POST['inputSituacao']."',
		problema = '".$_POST['inputProblema']."',
		usuario = '".$_POST['inputUsuario']."',
		matricula = '".$_POST['inputMatriculaUsuario']."',
		setor = '',
		unidade = '',
		id_chip = '".$_POST['inputChipOculto']."',
		numeroSerie = '".$_POST['inputNumeroSerie']."',
		versaoSO = '".$_POST['inputVersaoSO']."',
		acessoriosCapinha = '".$_POST['radioCapinha']."',
		acessoriosPelicula = '".$_POST['radioPelicula']."',
		acessoriosCarregador = '".$_POST['radioCarregador']."',
		acessoriosCabo = '".$_POST['radioCabo']."',
		acessoriosFone = '".$_POST['radioFone']."',
		SO = '".$_POST['inputSistemaOperacional']."',
		idMDM = '".$_POST['inputIdMDM']."'
		WHERE id=".$_POST['hiddenAparelho'];
	$res = sqlsrv_query($con, $sql);

	$sql1 = "INSERT INTO relatorios_historico (nome, hora, descricao, id_usuario, sistema, id_item) VALUES ('Telefone Editado', '".date("Y-m-d H:i:s")."', 'O Telefone ".$_POST['hiddenAparelho']." foi Editado com Sucesso.', '".$_SESSION['userId']."', '2', '".$_POST['hiddenAparelho']."')";
	$res1= sqlsrv_query($con, $sql1);

	//echo "AQUI: ".$sql1;

	$resultado = "Aparelho Alterado com Sucesso!";
	echo '<script type="text/JavaScript"> setTimeout(function(){ window.location = ""; } , 2000); </script>'; 
}