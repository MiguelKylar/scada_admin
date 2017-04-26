<?php
include("bd.php");
 $data = $_POST['elemento'];
$json = json_decode($data, true);
$largo = count($json);

	$id_elemento   = $json[0]['id_elemento'];
	$sql = "delete  from elemento_aplicacion where id_elemento = $id_elemento";
	$consulta = mysql_query($sql, $conEmp);

for ($m = 0; $m < $largo; $m++){
	$elemento    = $json[$m]['id_elemento'];
	$idapp   = $json[$m]['idapp'];   
	$id  = $json[$m]['id'];  	
	echo $sql = "select tabla from aplicacion2 where id_aplicacion = $idapp";
	$consulta = mysql_query($sql, $conEmp);
	if($datatmp = mysql_fetch_array($consulta)){
	  $tabla = $datatmp['tabla'];	
	}

	echo $sql = "INSERT INTO elemento_aplicacion (id_elemento,id,id_aplicacion,tabla) VALUES($elemento,$id,$idapp,'$tabla')";
	$consulta = mysql_query($sql, $conEmp) or die(mysql_error());
    
	if (!$consulta) {
    echo "mal";
	}else{
	echo "bien";
	}
}
?>
