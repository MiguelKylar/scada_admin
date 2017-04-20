<?php
$id_elemento = $_POST['id_elemento'];
$id_elemento = explode("_",$id_elemento);
$id_elemento = $id_elemento[1];
include("bd.php");
$indice = 0;

$sql = "select id_sensor,id_aplicacion,tipo,p0,p1,p2 from elemento_aplicacion where id_elemento = $id_elemento";
$consulta = mysql_query($sql, $conEmp);
while($datatmp = mysql_fetch_array($consulta)) {
    $id_sensor = $datatmp['id_sensor'];
	$tipoApi = $datatmp['tipo'];
	$id_aplicacion = $datatmp['id_aplicacion'];
	$p0 = $datatmp['p0'];
	$p1 = $datatmp['p1'];
	$p2 = $datatmp['p2'];
	if($tipoApi == 1){
	$sql = "select id_nodo,id_sensor,descripcion,tipo,valor from sensor where id_sensor = $id_sensor";
	$consulta1 = mysql_query($sql, $conEmp);
	$resultado = 0;
	while($datatmp1 = mysql_fetch_assoc($consulta1)){
	
	$sql = "select id_aplicacion as id, (SELECT url FROM aplicacion2 WHERE id_aplicacion = id) as url,(SELECT icono FROM aplicacion2 WHERE id_aplicacion = id) as icono from elemento_aplicacion where id_sensor = $id_sensor and tipo = 1";
	$consulta3 = mysql_query($sql, $conEmp);
	$m=0;
	while($datatmp3 = mysql_fetch_assoc($consulta3)) {
		$aplicacion[$m]= $datatmp3;
		$m++;
	}	
		$resultado = count($sensores);
			if($resultado == 0){
					$sensores[$indice] = $datatmp1;	
					$sensores[$indice]['id_aplicacion'] = $aplicacion;
					$tipo = $sensores[$indice]['tipo'];
					$sql = "select unidad from parametro where tipo = '$tipo'";
					$consulta2 = mysql_query($sql, $conEmp);
					while($datatmp2 = mysql_fetch_array($consulta2)){
						$unidad = $datatmp2['unidad'];
						$sensores[$indice]['unidad'] = $unidad;
					}
					
					$sql = "select url from parametro where tipo = '$tipo'";
					$consulta2 = mysql_query($sql, $conEmp);
					while($datatmp2 = mysql_fetch_array($consulta2)){
						$unidad = $datatmp2['unidad'];
						$sensores[$indice]['unidad'] = $unidad;
					}	
			}else{
				$sensores2[$indice] = $datatmp1;
				for ($i = 0; $i < $resultado; $i++) {
					if($sensores2[$indice]['tipo'] == $sensores[$i]['tipo']){
					$sw = 1;
					}
					if($sw != 1){
						$sensores[$indice] = $datatmp1;	
						$sensores[$indice]['id_aplicacion'] = $aplicacion;
						$tipo = $sensores[$indice]['tipo'];
						$sql = "select unidad from parametro where tipo = '$tipo'";
						$consulta2 = mysql_query($sql, $conEmp);
						while($datatmp2 = mysql_fetch_array($consulta2)){
							$unidad = $datatmp2['unidad'];
							$sensores[$indice]['unidad'] = $unidad;
						}
						
						$sql = "select url from parametro where tipo = '$tipo'";
						$consulta2 = mysql_query($sql, $conEmp);
						while($datatmp2 = mysql_fetch_array($consulta2)){
							$unidad = $datatmp2['unidad'];
							$sensores[$indice]['unidad'] = $unidad;
						}
					}else{
						$indice=$indice-1;
					}
				}$sw = 0;
		    }
		$indice = $indice+1;
		$aplicacion = null;
	}
	}elseif($tipoApi == 2){
	   $sql = "SELECT post,icono,url,id_aplicacion FROM aplicacion2 WHERE id_aplicacion = $id_aplicacion";
	   $consulta33 = mysql_query($sql, $conEmp);
	   while($datatmp9 = mysql_fetch_assoc($consulta33)){
		  $apis = $datatmp9;
	   }	
	   $sql = "select id_empresa,equipo,id_nodo,estado,nombre_sector from control_riego where id_nodo = $id_sensor and p0 = $p0 and p1 = $p1 and p2 = $p2";
	   $consulta33 = mysql_query($sql, $conEmp);
	   while($datatmp9 = mysql_fetch_assoc($consulta33)){
		   $id_nodo22 = $datatmp9['id_nodo'];
		   $estado22  = $datatmp9['estado'];
		   $id_empresa = $datatmp9['id_empresa'];
		   $id_equipo  = $datatmp9['equipo'];
		   if($estado22 == 1){
			   $estado22 = 'Funcionando';
		   }elseif($estado22 == 2  or $estado22 == 0){
			   $estado22 = 'Detenido';
		   }
		   $nombre_sector  = $datatmp9['nombre_sector'];
       	   $sensores[$indice]['id_nodo'] =  $id_nodo22;
		   $sensores[$indice]['valor'] =  $estado22;
		   $sensores[$indice]['unidad'] =  " ";
		   $sensores[$indice]['id_equipo'] =  $id_equipo;	
		   $sensores[$indice]['id_empresa'] =  $id_empresa;	
		   $sensores[$indice]['descripcion'] =  $nombre_sector;
		   $sensores[$indice]['tipo'] =  $tipoApi;
		   $sensores[$indice]['id_aplicacion'][0] =  $apis ;
	   }
	   $apis = null;
	   $indice++;
	}
}
echo json_encode($sensores);
?>