<?php

include "../conexao.php";

$arquivo = explode("
", file_get_contents("linhasDados.csv"));

for($x = 0; $x < count($arquivo); $x++) {
	echo "<p>".$arquivo[$x]."</p>";

	$sqlCheck = "SELECT * FROM relatorios_linhas WHERE numero LIKE '%".$arquivo[$x]."%'";
	$resCheck = mysql_query($sqlCheck, $con);
	$numCheck = mysql_num_rows($resCheck);

	echo "<p>SQL Check: ".$sqlCheck,"</p>";
	echo "<p>NUM Check: ".$numCheck,"</p>";

	if($numCheck > 0) {
		$rowCheck = mysql_fetch_array($resCheck);

		$sqlUpdate = "UPDATE relatorios_linhas SET status = 'Dados e Voz' WHERE id = '".$rowCheck["id"]."'";
		$resUpdate = mysql_query($sqlUpdate, $con);

		echo $sqlUpdate;

	}

	else {

		$sqlInsert = "INSERT INTO relatorios_linhas VALUES('', '".$arquivo[$x]."', '', 'Dados')";
		$resInsert = mysql_query($sqlInsert, $con);

	}

}
