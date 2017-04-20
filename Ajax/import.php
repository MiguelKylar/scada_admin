<?php
$id_elemento = $_POST['id_elemento'];
echo $id_elementoOriginal = $_POST['id_elementoOriginal'];
include("bd.php");

echo $sql = "select * from elemento_aplicacion where id_elemento = $id_elemento";
$consulta = mysql_query($sql, $conEmp);
while($datatmp = mysql_fetch_array($consulta)) {
	$id = $datatmp['id'];
	$tabla = $datatmp['tabla'];
	$id_aplicacion = $datatmp['id_aplicacion'];
	$prioridad = $datatmp['prioridad'];
	
	echo $sql = "INSERT INTO elemento_aplicacion (id_elemento,id,id_aplicacion,tabla,prioridad) VALUES($id_elementoOriginal,$id,$id_aplicacion,'$tabla',$prioridad)";
	$consulta1 = mysql_query($sql, $conEmp) or die(mysql_error());
}
?>  