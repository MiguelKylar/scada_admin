<?php
include("bd.php");
$id_empresa = $_POST['id_empresa'];
$id_tipo = $_POST['id_tipo'];
$sql = "select max(id_elemento) as maximo_elemento from elemento";
$consulta = mysql_query($sql, $conEmp);
if($datatmp = mysql_fetch_array($consulta)) {
    $maximo_elemento = $datatmp['maximo_elemento'];
	$maximo_elemento = $maximo_elemento+1;
}else{
 $maximo_elemento = 1;   
}
$nombre = 'valvula mariposa '.$maximo_elemento;
$sql = "INSERT INTO elemento (id_empresa,id_elemento,descripcion,tipo) VALUES($id_empresa,$maximo_elemento,'$nombre','$id_tipo')";
$consulta = mysql_query($sql, $conEmp) or die(mysql_error());
echo $maximo_elemento;
?>