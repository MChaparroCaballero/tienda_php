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

		$fecha_para_sql = date("Y-m-d");
        

		$_SESSION['carrito'] = [
            // Aquí NO va el ID autoincrement de la BD. El ID lo obtendrás cuando 
            // insertes la cabecera del carrito en la base de datos por primera vez.
            'CodCarro' => null, // Usaremos 'null' para indicar que no ha sido guardado aún
            'Fecha' => $fecha_para_sql, // Fecha de creación
            'Enviado' => 0, // Estado inicial (e.g., 0 = 'Pendiente/Abierto')
            
            // Este es el array que contendrá los productos (los detalles del carrito)
            'productos' => [] 
        ];
		header("Location: ../frontend/catalogo.php");
        exit;
	}	
}

    
	
?>