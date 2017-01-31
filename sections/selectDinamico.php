<?php 
include "../../sisti/conexao.php";

if($_GET['val'] == 'telefones') {

?>

<select name="inputIdItem" id="inputIdItem" required>
<option value="" disabled selected>ID do Item</option>
<?php 
$sql = "SELECT * FROM relatorios_telefones ORDER BY id DESC";
$res = sqlsrv_query($con, $sql);
while($row = sqlsrv_fetch_array($res)) {
?><option value="<?=$row['id']?>"><?=$row['id']?> - <?=$row['marca']?> - <?=$row['imei']?></option><?php } ?>
</select><span>*</span>

<?php } else if($_GET['val'] == 'chips') { ?>

<select name="inputIdItem" id="inputIdItem" required>
<option value="" disabled selected>ID do Item</option>
<?php 
$sql = "SELECT * FROM relatorios_chips ORDER BY id DESC";
$res = sqlsrv_query($con, $sql);
while($row = sqlsrv_fetch_array($res)) {
?><option value="<?=$row['id']?>"><?=$row['id']?> - <?=$row['operadora']?> - <?=$row['id_linha']?></option><?php } ?>
</select><span>*</span>

<?php } else { ?>

<select name="inputIdItem" id="inputIdItem" required>
<option value="" disabled selected>ID do Item</option>
<?php 
$sql = "SELECT * FROM relatorios_modens ORDER BY id DESC";
$res = sqlsrv_query($con, $sql);
while($row = sqlsrv_fetch_array($res)) {
?><option value="<?=$row['id']?>"><?=$row['id']?> - <?=$row['operadora']?> - <?=$row['imei']?></option><?php } ?>
</select><span>*</span>

<?php } ?>