<div id="dinamicoTelefones" ng-app="appTelefones" ng-controller="myCtrlTelefones">

<h1>Lista de Telefones</h1>

	<input placeholder="Pesquisa Rápida" name="pesquisarAparelhos" id="pesquisarAparelhos" type="text" ng-model="filtro"><a id="adicionarAparelho">Adicionar</a>

	<div class="tituloResultados">
	<a  class="linkTitulo selecionado" ng-click="ordenar('id');">ID</a><a  class="linkTitulo" ng-click="ordenar('marca');">Marca</a><a  class="linkTitulo" ng-click="ordenar('modelo');">Modelo</a><a  class="linkTitulo" ng-click="ordenar('usuario');">Usuário</a><a  class="linkTitulo" ng-click="ordenar('imei');">IMEI</a><a  class="linkTitulo" ng-click="ordenar('setor');">Setor</a>
	</div>

	<a data-cod="{{x.id}}" class="linhaResultado {{x.situacao}}" title="{{x.situacao}} {{x.problema}}" ng-repeat="x in recordsTelefones | orderBy:myOrderBy | filter: filtro">
		<div class="colunaResultado">{{x.id}}</div><div class="colunaResultado">{{x.marca}}</div><div class="colunaResultado">{{x.modelo}}</div><div class="colunaResultado">{{x.usuario}}</div><div class="colunaResultado">{{x.imei}}</div><div class="colunaResultado">{{x.setor}}</div>
	</a>

	<script>

	$(function() {
		$('.linkTitulo').click(function() {
			var elementos = document.getElementsByClassName('linkTitulo');

		for (var x = 0; x < elementos.length; x++) {
			elementos[x].className = "linkTitulo";
		}

		this.className = "linkTitulo selecionado";

		});
	});

	var app = angular.module("appTelefones", []);
	app.controller("myCtrlTelefones", function($scope) {
    
    $scope.recordsTelefones = [

	<?php

	if($_POST) include "../../sisti/conexao.php";

	$sql = "SELECT * FROM relatorios_telefones ORDER BY id DESC";
	$res = sqlsrv_query($con, $sql);
	//echo $con;

	$i = -1;
	while($row = sqlsrv_fetch_array($res)) {
	$i++;
		if($i == 0) echo "{";
		else echo ", {";
		echo "'id': ".$row['id'].", 'marca': '".$row['marca']."', 'modelo': '".$row['modelo']."', 'situacao': '".$row['situacao']."', 'usuario': '".$row['usuario']."', 'imei': '".$row['imei']."', 'setor': '".$row['setor']."', 'unidade': '".$row['unidade']."', 'problema': '".$row['problema']."' }";
	}
	
	?>

    ];
      $scope.ordenar = function(x) {
      	if($scope.myOrderBy == x) x = "-"+x;
	    $scope.myOrderBy = x;
	  }

});


$(function () {
	$( "section" ).delegate( ".linhaResultado", "click", function() {
	    var id = $(this).data('cod');
	    //alert("AQUI: "+id);
		//$('#telefones').html('Carregando...');
		// Do an ajax request
		$.ajax({
		  url: "aparelho.php?id="+id
		}).done(function(data) { // data what is sent back by the php page
		  $('#telefones').html(data); // display data
		});

	});

	$('#adicionarAparelho').click(function() {

		$("#telefones").html('<div class="spinner nofloat"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>');
		// Do an ajax request
		$.ajax({
		  url: "aparelho.php?id=novo"
		}).done(function(data) { // data what is sent back by the php page
		  setTimeout(function() { $('#telefones').html(data); }, 340); // display data
		});

	});
});

angular.bootstrap('#dinamicoTelefones', ['appTelefones']);
	
</script>

</div>