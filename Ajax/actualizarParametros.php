<?php
include("bd.php");
$json = $_POST['arregloJson'];
$largo = $_POST['largo'];
$json = json_decode($json, true);
$sql = "";
for ($m = 0; $m < $largo; $m++){
	$array = json_decode($json[$m], true);
	 $top    = $array["_top"];    
	 $left   = $array['_left'];   
	 $width  = $array['_width'];  
	 $heigth = $array['_heigth']; 
	 $img    = $array['_img'];    
	 $tipo    = $array['_tipo'];   
	 $idelemento    = $array['_idelemento'];    
	 $zIndex    = $array['_zIndex'];    
	if($tipo == 3){
	 $tamaño = $array['_tamaño'];   
	 $texto = $array['_texto'];  
		echo $sql= "UPDATE `elemento` SET  texto = '$texto', tipo = '$tipo',tamano_letra = '$tamaño', zIndex ='$zIndex',`top`='$top',`lefts`='$left',`width`='$width',`height`='$heigth' WHERE id_elemento =$idelemento;";
		$consulta = mysql_query($sql, $conEmp);	
	}else{
		$sql= "UPDATE `elemento` SET `zIndex`='$zIndex',`top`='$top',`lefts`='$left',`width`='$width',`height`='$heigth',`img`='$img' WHERE id_elemento =$idelemento;";
		$consulta = mysql_query($sql, $conEmp);	
	}




}
?> 