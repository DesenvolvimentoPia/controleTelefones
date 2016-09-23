<h2>Lista de Modens</h2>

	<input placeholder="Pesquisa Rápida" name="pesquisarModens" id="pesquisarModens" type="text" ng-model="filtroModen"><a id="adicionarModem">Adicionar</a>

	<div class="tituloResultados">
	<a  class="linkTitulo3 selecionado" ng-click="ordenar('id');">ID</a><a  class="linkTitulo3" ng-click="ordenar('operadora');">Operadora</a><a  class="linkTitulo3" ng-click="ordenar('usuario');">Usuário</a><a  class="linkTitulo3" ng-click="ordenar('imei');">IMEI</a><a  class="linkTitulo3" ng-click="ordenar('setor');">Setor</a><a  class="linkTitulo3" ng-click="ordenar('unidade');">Unidade</a>
	</div>

	<a data-cod="{{x.id}}" class="linhaResultado3 {{x.situacao}}" title="{{x.situacao}}" ng-repeat="x in recordsModens | orderBy:myOrderBy | filter: filtroModen">
		<div class="colunaResultado">{{x.id}}</div><div class="colunaResultado">{{x.operadora}}</div><div class="colunaResultado">{{x.usuario}}</div><div class="colunaResultado">{{x.imei}}</div><div class="colunaResultado">{{x.setor}}</div><div class="colunaResultado">{{x.unidade}}</div>
	</a>

	<script>

	$(function() {
		$('.linkTitulo3').click(function() {
			var elementos = document.getElementsByClassName('linkTitulo3');

		for (var x = 0; x < elementos.length; x++) {
			elementos[x].className = "linkTitulo3";
		}

		this.className = "linkTitulo3 selecionado";

		});
	});

	var app = angular.module("appModens", []);
	app.controller("myCtrlModens", function($scope) {
    
    $scope.recordsModens = [

	<?php

	$sql = "SELECT * FROM relatorios_modens ORDER BY id DESC";
	$res = mysql_query($sql, $con);
	$num = mysql_num_rows($res);

	for($i = 0; $i < $num; $i++) {
	$row = mysql_fetch_array($res);
		if($i == 0) echo "{";
		else echo ", {";
		echo "'id': ".$row['id'].", 'operadora': '".$row['operadora']."', 'situacao': '".$row['situacao']."', 'usuario': '".$row['usuario']."', 'imei': '".$row['imei']."', 'setor': '".$row['setor']."', 'unidade': '".$row['unidade']."', 'id_chip': '".$row['id_chip']."' }";
	}
	
	?>

    ];
      $scope.ordenar = function(x) {
      	if($scope.myOrderBy == x) x = "-"+x;
	    $scope.myOrderBy = x;
	  }

});


$(function () {
	$( "section" ).delegate( ".linhaResultado3", "click", function() {
	    var id = $(this).data('cod');
	    //alert("AQUI: "+id);
		//$('#modens').html('Carregando...');
		// Do an ajax request
		$.ajax({
		  url: "modem.php?id="+id
		}).done(function(data) { // data what is sent back by the php page
		  $('#modens').html(data); // display data
		});

	});

	$('#adicionarModem').click(function() {

		//$('#modens').html('Carregando...');
		// Do an ajax request
		$.ajax({
		  url: "modem.php?id=novo"
		}).done(function(data) { // data what is sent back by the php page
		  $('#modens').html(data); // display data
		});

	});
});

angular.bootstrap('#modens', ['appModens']);
	
</script>