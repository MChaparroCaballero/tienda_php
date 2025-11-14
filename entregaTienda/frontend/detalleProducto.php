<?php
// PHP busca el valor del parámetro 'id' en la URL
require '../backend/sesiones.php';
require_once '../backend/conectar.php';
require_once '../backend/obtenerProducto.php';



$producto_id = $_GET['id']; // Esto obtendrá el '1'
$resultado=obtenerDetalleProducto($producto_id,$bd);

// Es buena práctica sanear esto con htmlspecialchars antes de imprimir
// 1. Obtener solo el nombre base del archivo de la URL
// Usar basename() es clave para la seguridad aquí.
$nombre_base = basename($_GET['ruta']); 

// 2. CONCATENAR la ruta completa en una sola variable PHP
$ruta_imagen_final = "../imagenesTienda/" . $nombre_base;

// 3. Sanear la cadena FINAL completa para imprimirla en el HTML
$ruta_imagen_final_saneada = htmlspecialchars($ruta_imagen_final);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle</title>
    <script src="js/modificarCantidadComprar.js"></script>
</head>
<body>

    <img width="500rem" height="500rem" src="<?= $ruta_imagen_final_saneada ?>" alt="Imagen del Producto">
    <?php 
    echo "<h1>" . $resultado['Nombre'] . "</h1>";
    echo "<p>Descripción: " . $resultado['Descripcion'] . "</p>";
    echo "<h2>Precio: $" . $resultado['Precio'] . "</h2>";
    echo '<form method="POST" action="../backend/anadirAlCarro.php">';
    echo '<input type="hidden" name="producto_id" value="' . htmlspecialchars($resultado['CodProd']) . '">';
    echo '<input type="number" id="cantidad" name="cantidad" min="0" max="'. $resultado['Cantidad'] .'" value="0"></input>';
    echo '<button type="submit">Añadir al carrito</button>';
    echo "</form>"
    
    ?>
    
   
   

</body>
</html>