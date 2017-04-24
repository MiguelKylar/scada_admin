<?php

$id_empresa = $_POST['id_empresa'];
include("bd.php");

if (isset($_POST['id_elemento'])){
$id_elemento = $_POST['id_elemento'];   
$sql = "select * from elemento_aplicacion where id_elemento = $id_elemento order by id_elemento asc";
$consulta = mysql_query($sql, $conEmp);
$i=0;
while($datatmp = mysql_fetch_assoc($consulta)) {
	$elementos[$i] = $datatmp;
	$id_aplicacion = $elementos[$i]["id_aplicacion"];
	$sql1 = "select aplicacion from aplicacion2 where id_aplicacion = $id_aplicacion";
	$consulta1 = mysql_query($sql1, $conEmp);
	while($datatmp1 = mysql_fetch_array($consulta1)) {
		$elementos[$i]['aplicacion'] = $datatmp1['aplicacion']; 
	}
	$i++;	
}
}
$i=0;



		$x=0;
		$sql2 = "select aplicacion,id_aplicacion from aplicacion2";
		$consulta2 = mysql_query($sql2, $conEmp);
		while($datatmp2 = mysql_fetch_assoc($consulta2)) {
			$aplicaciones[$x] = $datatmp2;
			$x++;
		}
		$i++;
	

$i=0;
$sql = "SHOW TABLES FROM `temporal_lem_db`WHERE `Tables_in_temporal_lem_db` not LIKE 'muestra%'";	
$consulta = mysql_query($sql, $conEmp);
while($datatmp = mysql_fetch_assoc($consulta)) {
	$tablas[$i] = $datatmp;
	$i++;
}
$elementos[0]['aplicaciones'] = $aplicaciones;
echo json_encode($elementos);
?>