<?php
ob_start();
session_start();

require_once("../../BackEnd/modelo/class_usuario_front.php"); 
$user_obj = new usuario();
$data = $user_obj->f_usuario_logout();

?>