<div id="dinamicoLinhas" ng-app="appLinhas" ng-controller="myCtrlLinhas">

<h1>Lista de Linhas</h1>

	<input placeholder="Pesquisa Rápida" name="pesquisarLinhas" id="pesquisarLinhas" type="text" ng-model="filtroLinha"><a id="adicionarLinha">Adicionar</a>

	<div class="tituloResultados">
	<a  class="linkTitulo4 selecionado" ng-click="ordenar('id');">ID</a><a  class="linkTitulo4" ng-click="ordenar('numero');">Número</a><a  class="linkTitulo4" ng-click="ordenar('chip');">Usuário</a><a  class="linkTitulo4" ng-click="ordenar('status');">Status</a>
	</div>

	<a data-cod="{{x.id}}" class="linhaResultado4 {{x.situacao}}" title="{{x.situacao}}" ng-repeat="x in recordsLinhas | orderBy:myOrderBy | filter: filtroLinha">
		<div class="colunaResultado">{{x.id}}</div><div class="colunaResultado">{{x.numero}}</div><div class="colunaResultado">{{x.chip}}</div><div class="colunaResultado">{{x.status}}</div>
	</a>

	<script>

	$(function() {
		$('.linkTitulo4').click(function() {
			var elementos = document.getElementsByClassName('linkTitulo4');

		for (var x = 0; x < elementos.length; x++) {
			elementos[x].className = "linkTitulo4";
		}

		this.className = "linkTitulo4 selecionado";

		});
	});

	var app = angular.module("appLinhas", []);
	app.controller("myCtrlLinhas", function($scope) {
    
    $scope.recordsLinhas = [

	<?php

	if($_POST) include "../../sisti/conexao.php";

	$sql = "SELECT * FROM relatorios_linhas ORDER BY id DESC";
	$res = sqlsrv_query($con, $sql);
	$num = sqlsrv_num_rows($res);

	$i = -1;
while($row = sqlsrv_fetch_array($res)) {
$i++;
	
		if($i == 0) echo "{";
		else echo ", {";
		echo "'id': ".$row['id'].", 'numero': '".$row['numero']."', 'chip': '".$row['nomeUsuario']."', 'situacao': '".$row['situacao']."', 'status': '".$row['status']."' }";
	}
	
	?>

    ];
      $scope.ordenar = function(x) {
      	if($scope.myOrderBy == x) x = "-"+x;
	    $scope.myOrderBy = x;
	  }

});


$(function () {
	$( "section" ).delegate( ".linhaResultado4", "click", function() {
	    var id = $(this).data('cod');
	    //alert("AQUI: "+id);
		//$('#linhas').html('Carregando...');
		// Do an ajax request
		$.ajax({
		  url: "linha.php?id="+id
		}).done(function(data) { // data what is sent back by the php page
		  $('#linhas').html(data); // display data
		});

	});

	$('#adicionarLinha').click(function() {

		$("#linhas").html('<div class="spinner nofloat"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>');
		// Do an ajax request
		$.ajax({
		  url: "linha.php?id=novo"
		}).done(function(data) { // data what is sent back by the php page
		  setTimeout( function() { $('#linhas').html(data); }, 340); // display data
		});

	});
});

angular.bootstrap('#dinamicoLinhas', ['appLinhas']);
	
</script>

</div>