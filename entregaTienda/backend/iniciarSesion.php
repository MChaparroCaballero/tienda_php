<?php
require_once 'conectar.php';
/*formulario de login habitual
si va bien abre sesión, guarda el nombre de usuario y redirige a principal.php 
si va mal, mensaje de error */

function comprobar_usuario($bd,$gmail, $clave){
$ins = $bd->prepare("select id, nombre , gmail from usuarios where gmail = ? and clave = ?");

$resul=$ins->execute(array($gmail,$clave));
		
	if($ins->rowCount() === 1){		
		return $ins->fetch();		
	}else{
		return FALSE;
	}
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {  
	
	$usu = comprobar_usuario($bd,$_POST['gmail'], $_POST['clave']);
	if($usu===false){
		$err = true;
		$usuario = $_POST['gmail'];
	}else{
		session_start();
		// $usu tiene campos correo y codRes, correo 
		$_SESSION['usuario'] = $usu;
		$_SESSION['carrito'] = [];
		header("Location: ../frontend/catalogo.php");
        exit;
	}	
}

    
	
?>