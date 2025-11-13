<?php
$cadena_conexion = 'mysql:dbname=simulador_tienda;host=127.0.0.1;';
//para casa//
$cadena_conexion2 = 'mysql:dbname=simulador_tienda;host=127.0.0.1;port=3307';
$usuario = 'root';
$clave = '';
 $bd = new PDO($cadena_conexion2, $usuario, $clave);
    if(!$bd){
        throw new Exception("No se pudo conectar a la base de datos");
    }
?>