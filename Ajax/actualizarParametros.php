<?php
include("bd.php");
$json = $_POST['arregloJson'];
$largo = $_POST['largo'];
$json = json_decode($json, true);
$sql = "";
for ($m = 0; $m < $largo; $m++){
	$array = json_decode($json[$m], true);
	echo $top    = $array["_top"];    echo "\n";
	echo $left   = $array['_left'];   echo "\n";
	echo $width  = $array['_width'];  echo "\n";
	echo $heigth = $array['_heigth']; echo "\n";
	echo $img    = $array['_img'];    echo "\n";
	echo $tipo    = $array['_tipo'];   echo "\n";
	echo $idelemento    = $array['_idelemento'];    echo "\n";
	echo $zIndex    = $array['_zIndex'];    echo "\n";
	if($tipo == 3){
	echo $tamaño = $array['_tamaño'];   echo "\n";
	echo $texto = $array['_texto'];   echo "\n";
		echo $sql= "UPDATE `elemento` SET  texto = '$texto', tipo = '$tipo',tamano_letra = '$tamaño', zIndex ='$zIndex',`top`='$top',`lefts`='$left',`width`='$width',`height`='$heigth' WHERE id_elemento =$idelemento;";
		$consulta = mysql_query($sql, $conEmp);	
	}else{
		$sql= "UPDATE `elemento` SET `zIndex`='$zIndex',`top`='$top',`lefts`='$left',`width`='$width',`height`='$heigth',`img`='$img' WHERE id_elemento =$idelemento;";
		$consulta = mysql_query($sql, $conEmp);	
	}




}
?> 