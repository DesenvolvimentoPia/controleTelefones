<?php

session_start();

include "../sisti/conexao.php";

$sql = "UPDATE relatorios_movimentos SET is_deleted = 1 WHERE id = ".$_GET['id'];
$res = sqlsrv_query($con, $sql);

