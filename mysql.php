<?php
//echo "TEST";
//var_dump($bd_host);die;
$conn = new mysqli($bd_host, $bd_usuario, $bd_senha, $bd_name, $bd_port); 
$conn->set_charset("utf8");

?>