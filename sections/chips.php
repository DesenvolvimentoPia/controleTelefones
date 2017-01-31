<div id="dinamicoChips" ng-app="appChips" ng-controller="myCtrlChips">

<h1>Lista de Chips</h1>

	<input placeholder="Pesquisa Rápida" name="pesquisarChips" id="pesquisarChips" type="text" ng-model="filtroChip"><a id="adicionarChip">Adicionar</a>

	<div class="tituloResultados">
	<a  class="linkTitulo5 selecionado" ng-click="ordenar('id');">ID</a><a  class="linkTitulo5" ng-click="ordenar('numero');">Número</a><a  class="linkTitulo5" ng-click="ordenar('nomeUsuario');">Usuário</a><a class="linkTitulo5" ng-click="ordenar('id_linha');">Linha</a><a class="linkTitulo5" ng-click="ordenar('operadora');">Operadora</a>
	</div>

	<a data-cod="{{x.id}}" class="linhaResultado5 {{x.situacao}}" title="{{x.situacao}}" ng-repeat="x in recordsChips | orderBy:myOrderBy | filter: filtroChip">
		<div class="colunaResultado">{{x.id}}</div><div class="colunaResultado">{{x.numero}}</div><div class="colunaResultado">{{x.nomeUsuario}}</div><div class="colunaResultado">{{x.id_linha}}</div><div class="colunaResultado">{{x.operadora}}</div>
	</a>

	<script>

	$(function() {
		$('.linkTitulo5').click(function() {
			var elementos = document.getElementsByClassName('linkTitulo5');

		for (var x = 0; x < elementos.length; x++) {
			elementos[x].className = "linkTitulo5";
		}

		this.className = "linkTitulo5 selecionado";

		});
	});

	var app = angular.module("appChips", []);
	app.controller("myCtrlChips", function($scope) {
    
    $scope.recordsChips = [

	<?php

	if($_POST) include "../../sisti/conexao.php";

	$sql = "SELECT a.id, a.numero, a.situacao, a.id_linha AS linha,
	b.nomeUsuario,
	a.operadora FROM relatorios_chips a
	LEFT JOIN relatorios_linhas b ON 
	a.id_linha LIKE b.numero WHERE a.operadora NOT LIKE 'Claro' ORDER BY a.id DESC";
	$res = sqlsrv_query($con, $sql);

	//echo $sql;

	$i = -1;
	while($row = sqlsrv_fetch_array($res)) {
	$i++;

	if($row['linha'] == null) $row['linha'] = "Sem Linha";
		if($i == 0) echo "{";
		else echo ", {";
		echo "'id': ".$row['id'].", 'numero': '".$row['numero']."', 'situacao': '".$row['situacao']."', 'id_linha': '".$row['linha']."', 'nomeUsuario': '".$row['nomeUsuario']."', 'operadora': '".$row['operadora']."' }";
	}
	
	?>

    ];
      $scope.ordenar = function(x) {
      	if($scope.myOrderBy == x) x = "-"+x;
	    $scope.myOrderBy = x;
	  }

});


$(function () {
	$( "section" ).delegate( ".linhaResultado5", "click", function() {
	    var id = $(this).data('cod');
	    //alert("AQUI: "+id);
		//$('#linhas').html('Carregando...');
		// Do an ajax request
		$.ajax({
		  url: "chip.php?id="+id
		}).done(function(data) { // data what is sent back by the php page
		  $('#chips').html(data); // display data
		});

	});

	$('#adicionarChip').click(function() {

		$("#chips").html('<div class="spinner nofloat"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>');
		// Do an ajax request
		$.ajax({
		  url: "chip.php?id=novo"
		}).done(function(data) { // data what is sent back by the php page
		  setTimeout(function() { $('#chips').html(data); }, 340); // display data
		});

	});
});

angular.bootstrap('#dinamicoChips', ['appChips']);
	
</script>

</div> 