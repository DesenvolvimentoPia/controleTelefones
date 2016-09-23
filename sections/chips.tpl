<h2>Lista de Chips</h2>

	<input placeholder="Pesquisa Rápida" name="pesquisarChips" id="pesquisarChips" type="text" ng-model="filtroChip"><a id="adicionarChip">Adicionar</a>

	<div class="tituloResultados">
	<a  class="linkTitulo5 selecionado" ng-click="ordenar('id');">ID</a><a  class="linkTitulo5" ng-click="ordenar('numero');">Número</a><a  class="linkTitulo5" ng-click="ordenar('chip');">Tipo de Chip</a><a  class="linkTitulo5" ng-click="ordenar('id_linha');">Linha</a>
	</div>

	<a data-cod="{{x.id}}" class="linhaResultado5 {{x.situacao}}" title="{{x.situacao}}" ng-repeat="x in recordsChips | orderBy:myOrderBy | filter: filtroChip">
		<div class="colunaResultado">{{x.id}}</div><div class="colunaResultado">{{x.numero}}</div><div class="colunaResultado"><span class="{{x.normal}}">{{x.normal}}</span><span class="{{x.micro}}">{{x.micro}}</span><span class="{{x.nano}}">{{x.nano}}</span></div><div class="colunaResultado">{{x.id_linha}}</div>
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

	$sql = "SELECT relatorios_chips.id AS id, relatorios_chips.numero AS numero, relatorios_chips.situacao AS situacao, relatorios_chips.id_linha AS id_linha,
	CASE relatorios_chips.normal WHEN 'X' THEN 'Normal' ELSE 'nao' END AS normal,
	CASE relatorios_chips.micro WHEN 'X' THEN 'Micro' ELSE 'nao' END AS micro,
	CASE relatorios_chips.nano WHEN 'X' THEN 'Nano' ELSE 'nao' END AS nano,
	relatorios_linhas.numero AS linha
	FROM relatorios_chips LEFT JOIN relatorios_linhas ON
	relatorios_chips.id_linha = relatorios_linhas.id ORDER BY id DESC";
	$res = mysql_query($sql, $con);
	$num = mysql_num_rows($res);

	for($i = 0; $i < $num; $i++) {
	$row = mysql_fetch_array($res);
	if($row['linha'] == null) $row['linha'] = "Sem Linha";
		if($i == 0) echo "{";
		else echo ", {";
		echo "'id': ".$row['id'].", 'numero': '".$row['numero']."', 'situacao': '".$row['situacao']."', 'id_linha': '".$row['linha']."', 'normal': '".$row['normal']."', 'micro': '".$row['micro']."', 'nano': '".$row['nano']."' }";
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

		//$('#linhas').html('Carregando...');
		// Do an ajax request
		$.ajax({
		  url: "chip.php?id=novo"
		}).done(function(data) { // data what is sent back by the php page
		  $('#chips').html(data); // display data
		});

	});
});

angular.bootstrap('#chips', ['appChips']);
	
</script>