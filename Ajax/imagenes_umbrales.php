<?php
$id_elemento = $_POST['id_elemento'];
$img = $_POST['img'];
$inputImgDown = $_POST['inputImgDown'];
$inputImgUp = $_POST['inputImgUp'];
$inputImgNeutral = $_POST['inputImgNeutral'];
include("bd.php");

$sql= "UPDATE `elemento` SET `img`='$img',`img_neutral`='$inputImgNeutral',`img_down`='$inputImgDown',`img_up`='$inputImgUp' WHERE id_elemento =$id_elemento";
$consulta = mysql_query($sql, $conEmp);

