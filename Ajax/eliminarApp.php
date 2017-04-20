<?php
include("bd.php");
$id_elemento = $_POST['id_elemento'];
$id_sensor = $_POST['id_sensor'];
$id_aplicacion = $_POST['id_aplicacion'];

$sql = "DELETE FROM `elemento_aplicacion` WHERE id_elemento = $id_elemento and id_sensor = $id_sensor and id_aplicacion = $id_aplicacion";
$consulta = mysql_query($sql, $conEmp);

?>