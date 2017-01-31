<div id="dinamicoMovimentos" ng-app="appMovimentos" ng-controller="myCtrlMovimentos">

<h1>Consultar Movimentos</h1>

<input placeholder="Pesquisa Rápida" name="pesquisarMovimentos" id="pesquisarMovimentos" type="text" ng-model="filtroMovimento"><a id="adicionarMovimento">Movimentar</a>


	<div class="tituloResultados">
		<a class="linkTitulo6 selecionado" ng-click="ordenar2('id');">ID</a><a class="linkTitulo6" ng-click="ordenar2('diaHora');">Dia e Hora</a><a  class="linkTitulo6" ng-click="ordenar2('tipo_item');">Tipo</a><a  class="linkTitulo6" ng-click="ordenar2('id_item');">Item</a><a  class="linkTitulo6" ng-click="ordenar2('direcao');">Direção</a><a  class="linkTitulo6" ng-click="ordenar2('usuario');">Responsável</a>
	</div>

	<a data-cod="{{y.id}}"  class="linhaResultado6 {{y.situacao}" ng-repeat="y in records.sort | orderBy:myOrderBy2 | filter: filtroMovimento">
		<div class="colunaResultado">{{y.id}}</div><div class="colunaResultado">{{y.diaHora}}</div><div class="colunaResultado">{{y.tipo_item}}</div><div class="colunaResultado">{{y.id_item}}</div><div class="colunaResultado">{{y.direcao}}</div><div class="colunaResultado">{{y.usuario}}</div>
	</a>

	<script>

	$(function() {
		$('.linkTitulo6').click(function() {
			var elementos = document.getElementsByClassName('linkTitulo6');

		for (var x = 0; x < elementos.length; x++) {
			elementos[x].className = "linkTitulo6";
		}

		this.className = "linkTitulo6 selecionado";

		});
	});

	var appMovimentos = angular.module("appMovimentos", [])
	.controller("myCtrlMovimentos", function($scope) {
    
    $scope.records = { "sort" : [

	<?php

	if($_POST) include "../../sisti/conexao.php";

	$sql = "SELECT * FROM relatorios_movimentos WHERE is_deleted != 1 ORDER BY id DESC";
	$res = sqlsrv_query($con, $sql);
	$num = sqlsrv_num_rows($res);

	$i = -1;
	while($row = sqlsrv_fetch_array($res)) {
	$i++;
		if($i == 0) echo "{";
		else echo ", {";
		echo "'diaHora': '".$row['data']->format('d/m/Y')."', 'direcao': '".$row['direcao']."', 'id': ".$row['id'].", 'usuario': '".$row['usuario']."', 'tipo_item': '".$row['tipo_item']."', 'id_item': ".$row['id_item']." }";
	}
	
	?>

    ] }

      $scope.ordenar2 = function(y) {
      	if($scope.myOrderBy2 == y) y = "-"+y; 
	    $scope.myOrderBy2 = y;
	  }
});




$(function () {

	$( "section" ).delegate( ".linhaResultado6", "click", function() {
	    var id = $(this).data('cod');
	    //alert("AQUI: "+id);
		//$('#telefones').html('Carregando...');
		// Do an ajax request
		$.ajax({
		  url: "movimento.php?id="+id
		}).done(function(data) { // data what is sent back by the php page
		  $('#movimentos').html(data); // display data
		});

	});

	$('#adicionarMovimento').click(function() {

		$("#movimentos").html('<div class="spinner nofloat"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>');
		// Do an ajax request
		$.ajax({
		  url: "movimento.php?id=novo"
		}).done(function(data) { // data what is sent back by the php page
		  setTimeout(function() { $('#movimentos').html(data); }, 340); // display data
		});

	});
});

angular.bootstrap('#dinamicoMovimentos', ['appMovimentos']);

</script>

</div>