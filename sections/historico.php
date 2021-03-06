<div id="dinamicoHistorico" ng-app="appHistorico" ng-controller="myCtrlHistorico">

<h1>Consultar Histórico</h1>

	<div class="tituloResultados">
		<a class="linkTitulo2 selecionado" ng-click="ordenar2('diaHora');">Dia e Hora</a><a  class="linkTitulo2" ng-click="ordenar2('evento');">Evento</a><a  class="linkTitulo2" ng-click="ordenar2('descricao');">Descrição</a><a  class="linkTitulo2" ng-click="ordenar2('usuario');">Usuário</a>
	</div>

	<div class="linhaResultado" ng-repeat="y in records | orderBy:myOrderBy2">
		<div class="colunaResultado2">{{y.diaHora}}</div><div class="colunaResultado2">{{y.evento}}</div><div class="colunaResultado2">{{y.descricao}}</div><div class="colunaResultado2">{{y.usuario}}</div>
	</div>

	<script>

	$(function() {
		$('.linkTitulo2').click(function() {
			var elementos = document.getElementsByClassName('linkTitulo2');

		for (var x = 0; x < elementos.length; x++) {
			elementos[x].className = "linkTitulo2";
		}

		this.className = "linkTitulo2 selecionado";

		});
	});

	var appHistorico = angular.module("appHistorico", [])
	.controller("myCtrlHistorico", function($scope) {
    
    $scope.records = [

	<?php

	if($_POST) include "../../sisti/conexao.php";

	$sql = "SELECT relatorios_historico.id, relatorios_historico.nome, hora, descricao, relatorios_usuarios.nome AS usuario FROM relatorios_historico LEFT JOIN relatorios_usuarios ON relatorios_historico.id_usuario = relatorios_usuarios.id  WHERE sistema = 2 ORDER BY relatorios_historico.id DESC";
	$res = sqlsrv_query($con, $sql);
	$num = sqlsrv_num_rows($res);

	$i = -1;
while($row = sqlsrv_fetch_array($res)) {
$i++;
	
		if($i == 0) echo "{";
		else echo ", {";
		echo "'diaHora': '".$row['hora']->format('d/m/Y')."', 'evento': '".$row['nome']."', 'descricao': '".$row['descricao']."', 'usuario': '".$row['usuario']."' }";
	}
	
	?>

    ];
      $scope.ordenar2 = function(y) {
      	if($scope.myOrderBy2 == y) y = "-"+y;
	    $scope.myOrderBy2 = y;
	  }
});

angular.bootstrap('#dinamicoHistorico', ['appHistorico']);

</script>

</div>