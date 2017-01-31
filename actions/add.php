<?php

/* Trecho Responsável pela adição de um Movimento no Banco de Dados */

if(!empty($_POST['hiddenNovoMovimento'])) {

	$pasta = "termos/";

	if(isset($_FILES['inputTermo']['name'])) {
		$termo = $pasta .$_POST['inputIdItemOculto']."-". str_replace("'", "-", basename($_FILES['inputTermo']['name']));
		move_uploaded_file($_FILES['inputTermo']['tmp_name'], $termo);
	}

	$pasta2 = "fotos/";

	if(isset($_FILES['inputFoto']['name'])) {
		$foto = $pasta2 .$_POST['inputIdItemOculto']."-". str_replace("'", "-", basename($_FILES['inputFoto']['name']));
		move_uploaded_file($_FILES['inputFoto']['tmp_name'], $foto);
	}


	$sql = "INSERT INTO relatorios_movimentos (tipo_item, id_item, direcao, tipo_usuario, usuario, matricula, data, situacao
      , descricao, termo, foto, is_deleted) VALUES ('".$_POST['inputTipoItem']."', '".$_POST['inputIdItemOculto']."', '".$_POST['inputDirecao']."', '".$_POST['inputTipoUsuario']."', '".$_POST['inputUsuario']."', '".$_POST['inputMatriculaUsuario']."', '".date("Y-m-d H:i:s")."', '".$_POST['inputSituacao']."', '".$_POST['inputDescricao']."', '".$termo."', '".$foto."', 0)";
	$res = sqlsrv_query($con, $sql);
	//echo $sql;

	$lastRes = sqlsrv_query($con, "SELECT SCOPE_IDENTITY()");
	$lastId = sqlsrv_fetch_array($lastRes)[0];

	$sql1 = "INSERT INTO relatorios_historico (nome, hora, descricao, id_usuario, sistema, id_item) VALUES ('Movimento Adicionado', '".date("Y-m-d H:i:s")."', 'Um Novo Movimento foi Adicionado com Sucesso.', '".$_SESSION['userId']."', '2', '".$lastId."')";
	$res1= sqlsrv_query($con, $sql1);

	$sqlMov = "SELECT * FROM relatorios_movimentos ORDER BY id DESC";
	$resMov = sqlsrv_query($con, $sqlMov);
	$rowMov = sqlsrv_fetch_array($resMov);

	$resultado = "Movimento Inserido com Sucesso!";

	echo '<script type="text/JavaScript"> setTimeout(function(){ window.location = ""; } , 2000); </script>'; 

	if($_POST['inputTipoItem'] == "telefones" && $_POST['inputDirecao'] == "Entrega") {

		$sqlCel = "SELECT relatorios_telefones.id, relatorios_telefones.marca, relatorios_telefones.modelo, relatorios_telefones.imei, relatorios_telefones.pin, relatorios_chips.id AS chip, relatorios_linhas.id AS linha FROM relatorios_telefones 
		LEFT JOIN relatorios_chips ON
		relatorios_telefones.id_chip = relatorios_chips.id
		
		LEFT JOIN relatorios_linhas ON
		relatorios_chips.id_linha LIKE relatorios_linhas.numero
		
		WHERE relatorios_telefones.id = '".$_POST['inputIdItemOculto']."'";
		$resCel = sqlsrv_query($con, $sqlCel);
		$rowCel = sqlsrv_fetch_array($resCel);

		if(!empty($rowCel['id'])) {
			$sqlChip = "UPDATE relatorios_telefones SET situacao = '".$_POST['inputSituacao']."', usuario = '".$_POST['inputUsuario']."', matricula = '".$_POST['inputMatriculaUsuario']."' WHERE id = ".$rowCel['id'];
			$resChip = sqlsrv_query($con, $sqlChip);
		}

		if(!empty($rowCel['chip'])) {
			$sqlChip = "UPDATE relatorios_chips SET situacao = '".$_POST['inputSituacao']."' WHERE id = ".$rowCel['chip'];
			$resChip = sqlsrv_query($con, $sqlChip);
		}

		if(!empty($rowCel['linha'])) {
			$sqlChip = "UPDATE relatorios_linhas SET situacao = '".$_POST['inputSituacao']."', nomeUsuario = '".$_POST['inputUsuario']."', matricula = '".$_POST['inputMatriculaUsuario']."' WHERE id = ".$rowCel['linha'];
			$resChip = sqlsrv_query($con, $sqlChip);
		}
	}

	else if($_POST['inputTipoItem'] == "telefones" && $_POST['inputDirecao'] == "Devolução") {

		$sqlCel = "SELECT relatorios_telefones.id, relatorios_telefones.marca, relatorios_telefones.modelo, relatorios_telefones.imei, relatorios_telefones.pin, relatorios_chips.id AS chip, relatorios_linhas.id AS linha FROM relatorios_telefones 
		LEFT JOIN relatorios_chips ON
		relatorios_telefones.id_chip = relatorios_chips.id
		
		LEFT JOIN relatorios_linhas ON
		relatorios_chips.id_linha LIKE relatorios_linhas.numero
		
		WHERE relatorios_telefones.id = '".$_POST['inputIdItemOculto']."'";
		$resCel = sqlsrv_query($con, $sqlCel);
		$rowCel = sqlsrv_fetch_array($resCel);

		if(!empty($rowCel['id'])) {
			$sqlChip = "UPDATE relatorios_telefones SET situacao = '".$_POST['inputSituacao']."', usuario = '', matricula = '' WHERE id = ".$rowCel['id'];
			$resChip = sqlsrv_query($con, $sqlChip);
		}

		if(!empty($rowCel['chip'])) {
			$sqlChip = "UPDATE relatorios_chips SET situacao = '".$_POST['inputSituacao']."' WHERE id = ".$rowCel['chip'];
			$resChip = sqlsrv_query($con, $sqlChip);
		}

		if(!empty($rowCel['linha'])) {
			$sqlChip = "UPDATE relatorios_linhas SET situacao = '".$_POST['inputSituacao']."', nomeUsuario = '', matricula = '' WHERE id = ".$rowCel['linha'];
			$resChip = sqlsrv_query($con, $sqlChip);
		}
	}

	else if($_POST['inputTipoItem'] == "chips" && $_POST['inputDirecao'] == "Entrega") {

		$sqlCel = "SELECT a.*, b.id AS linha FROM relatorios_chips a		
		
		LEFT JOIN relatorios_linhas b ON
		a.id_linha LIKE b.numero
		
		WHERE a.id = '".$_POST['inputIdItemOculto']."'";
		$resCel = sqlsrv_query($con, $sqlCel);
		$rowCel = sqlsrv_fetch_array($resCel);

		if(!empty($rowCel['id'])) {
			$sqlChip = "UPDATE relatorios_chips SET situacao = '".$_POST['inputSituacao']."' WHERE id = ".$rowCel['id'];
			$resChip = sqlsrv_query($con, $sqlChip);
		}

		if(!empty($rowCel['linha'])) {
			$sqlChip = "UPDATE relatorios_linhas SET situacao = '".$_POST['inputSituacao']."', nomeUsuario = '".$_POST['inputUsuario']."', matricula = '".$_POST['inputMatriculaUsuario']."' WHERE id = ".$rowCel['linha'];
			$resChip = sqlsrv_query($con, $sqlChip);
		}
	}

	else if($_POST['inputTipoItem'] == "chips" && $_POST['inputDirecao'] == "Devolução") {

		$sqlCel = "SELECT a.*, b.id AS linha FROM relatorios_chips a		
		
		LEFT JOIN relatorios_linhas b ON
		a.id_linha LIKE b.numero
		
		WHERE relatorios_chips.id = '".$_POST['inputIdItemOculto']."'";
		$resCel = sqlsrv_query($con, $sqlCel);
		$rowCel = sqlsrv_fetch_array($resCel);

		if(!empty($rowCel['id'])) {
			$sqlChip = "UPDATE relatorios_chips SET situacao = '".$_POST['inputSituacao']."' WHERE id = ".$rowCel['id'];
			$resChip = sqlsrv_query($con, $sqlChip);
		}

		if(!empty($rowCel['linha'])) {
			$sqlChip = "UPDATE relatorios_linhas SET situacao = '".$_POST['inputSituacao']."', nomeUsuario = '', matricula = '' WHERE id = ".$rowCel['linha'];
			$resChip = sqlsrv_query($con, $sqlChip);
		}
	}
}



/* Trecho Responsável pela adição de um Chip no Banco de Dados */

if(!empty($_POST['hiddenNovoChip'])) {
	$sql = "INSERT INTO relatorios_chips (numero, normal, micro, nano, id_linha, situacao, operadora, email, senha) VALUES ('".$_POST['inputNumero']."', '".$_POST['inputNormal']."', '".$_POST['inputMicro']."', '".$_POST['inputNano']."', '".$_POST['inputLinha']."', '".$_POST['inputSituacao']."', '".$_POST['inputOperadora']."', '".$_POST['inputEmail']."', '".$_POST['inputSenha']."')";
	$res = sqlsrv_query($con, $sql);

	$lastRes = sqlsrv_query($con, "SELECT SCOPE_IDENTITY()");
	$lastId = sqlsrv_fetch_array($lastRes)[0];

	$sql1 = "INSERT INTO relatorios_historico (nome, hora, descricao, id_usuario, sistema, id_item) VALUES ('Chip Adicionado', '".date("Y-m-d H:i:s")."', 'Um Novo Chip foi Adicionado com Sucesso.', '".$_SESSION['userId']."', '2', '".$lastId."')";
	$res1= sqlsrv_query($con, $sql1);

	$resultado = "Chip Inserido com Sucesso!";

	echo '<script type="text/JavaScript"> setTimeout(function(){ window.location = ""; } , 2000); </script>'; 
}



/* Trecho Responsável pela adição de uma Linha no Banco de Dados */

if(!empty($_POST['hiddenNovoLinha'])) {
	$sql = "INSERT INTO relatorios_linhas (numero, situacao, status, cota, nomeUsuario, matricula) VALUES ('".$_POST['inputNumero']."', '".$_POST['inputSituacao']."', '".$_POST['inputStatus']."', '".$_POST['inputCota']."', '".$_POST['inputUsuario']."', '".$_POST['inputMatriculaUsuario']."')";
	$res = sqlsrv_query($con, $sql);

	$lastRes = sqlsrv_query($con, "SELECT SCOPE_IDENTITY()");
	$lastId = sqlsrv_fetch_array($lastRes)[0];

	$sql1 = "INSERT INTO relatorios_historico (nome, hora, descricao, id_usuario, sistema, id_item) VALUES ('Linha Adicionada', '".date("Y-m-d H:i:s")."', 'Uma Nova Linha foi Adicionada com Sucesso.', '".$_SESSION['userId']."', '2', '".$lastId."')";
	$res1= sqlsrv_query($con, $sql1);

	$resultado = "Linha Inserida com Sucesso!";

	echo '<script type="text/JavaScript"> setTimeout(function(){ window.location = ""; } , 2000); </script>'; 
}



/* Trecho Responsável pela adição de um Modem no Banco de Dados */

if(!empty($_POST['hiddenNovoModem'])) {
	$sql = "INSERT INTO relatorios_modens (operadora, imei, situacao, usuario, matricula, setor, unidade, id_chip) VALUES ('".$_POST['inputOperadora']."', '".$_POST['inputImei']."', '".$_POST['inputSituacao']."', '".$_POST['inputUsuario']."', '".$_POST['inputMatriculaUsuario']."', '".$_POST['inputSetor']."', '".$_POST['inputUnidade']."', '".$_POST['inputChip']."')";
	$res = sqlsrv_query($con, $sql);

	$lastRes = sqlsrv_query($con, "SELECT SCOPE_IDENTITY()");
	$lastId = sqlsrv_fetch_array($lastRes)[0];

	$sql1 = "INSERT INTO relatorios_historico (nome, hora, descricao, id_usuario, sistema, id_item) VALUES ('Modem Adicionado', '".date("Y-m-d H:i:s")."', 'Um Novo Modem foi Adicionado com Sucesso.', '".$_SESSION['userId']."', '2', '".$lastId."')";
	$res1= sqlsrv_query($con, $sql1);

	$resultado = "Modem Inserido com Sucesso!";

	echo '<script type="text/JavaScript"> setTimeout(function(){ window.location = ""; } , 2000); </script>'; 
}




/* Trecho Responsável pela adição de um Aparelho no Banco de Dados */

if(!empty($_POST['hiddenNovoAparelho'])) {
	$sql = "INSERT INTO relatorios_telefones (marca, modelo, imei, pin, situacao, problema, usuario, matricula, setor, unidade, id_chip, numeroSerie, versaoSO, acessoriosCapinha, acessoriosPelicula, acessoriosCarregador, acessoriosCabo, acessoriosFone, SO, idMDM) VALUES ('".$_POST['inputMarca']."', '".$_POST['inputModelo']."', '".$_POST['inputImei']."', '".$_POST['inputPin']."', '".$_POST['inputSituacao']."', '".$_POST['inputProblema']."', '".$_POST['inputUsuario']."', '', '', '".$_POST['inputMatriculaUsuario']."', '".$_POST['inputChipOculto']."', '".$_POST['inputNumeroSerie']."', '".$_POST['inputVersaoSO']."', '".$_POST['radioCapinha']."', '".$_POST['radioPelicula']."', '".$_POST['radioCarregador']."', '".$_POST['radioCabo']."', '".$_POST['radioFone']."', '".$_POST['inputSistemaOperacional']."', '".$_POST['inputIdMDM']."')";
	$res = sqlsrv_query($con, $sql);

	//echo $sql;

	$lastRes = sqlsrv_query($con, "SELECT SCOPE_IDENTITY()");
	$lastId = sqlsrv_fetch_array($lastRes)[0];

	$sql1 = "INSERT INTO relatorios_historico (nome, hora, descricao, id_usuario, sistema, id_item) VALUES ('Telefone Adicionado', '".date("Y-m-d H:i:s")."', 'Um Novo Telefone foi Adicionado com Sucesso.', '".$_SESSION['userId']."', '2', '".$lastId."')";
	$res1= sqlsrv_query($con, $sql1);

	$resultado = "Aparelho Inserido com Sucesso!";

	echo '<script type="text/JavaScript"> setTimeout(function(){ window.location = ""; } , 2000); </script>'; 
}