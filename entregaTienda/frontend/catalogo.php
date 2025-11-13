<?php
/*comprueba que el usuario*/
require '../backend/sesiones.php';
require_once '../backend/conectar.php';
comprobar_sesion();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>>Lista de categorías</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> <!--para los iconos-->
    <link rel="stylesheet" href="./css/catalogo.css">
</head>
<body>
    <header>
    <a href="carrito.php" title="Ir al Carrito">
        <button type="button">
            <i class="fas fa-shopping-cart"></i>
        </button>
    </a>
</header>
    <main>
            <div id="catalogo">
                <a href="detalleProducto.php?id=1&ruta=apple.jpg">
                <h3>Manzana</h3>
                <img src="../imagenesTienda/apple.jpg" ></a>
            
                <a href="detalleProducto.php?id=2&ruta=avocado.jpg">
                <h3>Avocado</h3>
                <img src="../imagenesTienda/avocado.jpg"></a>

                <a href="detalleProducto.php?id=3&ruta=bananas.jpg">
                <h3>Bananas</h3>
                <img src="../imagenesTienda/bananas.jpg"></a>

                <a href="detalleProducto.php?id=4&ruta=blueberries.jpg">
                <h3>Arandanos</h3>
                <img src="../imagenesTienda/blueberries.jpg"></a>
            
                <a href="detalleProducto.php?id=5&ruta=bread.jpg">
                <h3>Pan</h3>
                <img src="../imagenesTienda/bread.jpg"></a>
            
                <a href="detalleProducto.php?id=6&ruta=bulbs.jpg">
                <h3>Bulbos</h3>
                <img src="../imagenesTienda/bulbs.jpg"></a>
             
                <a href="detalleProducto.php?id=7&ruta=carrots.jpg">
                <h3>Zanahorias</h3>
                <img src="../imagenesTienda/carrots.jpg"></a>
                
                <a href="detalleProducto.php?id=9&ruta=peras.jpg">
                <h3>Peras</h3>
                <img src="../imagenesTienda/peras.jpg"></a>

                <a href="detalleProducto.php?id=8&ruta=oranges.jpg">
                <h3>Naranjas</h3>
                <img src="../imagenesTienda/oranges.jpg" ></a>
             
                <a href="detalleProducto.php?id=10&ruta=watermelons.jpg">
                <h3>Sandia</h3>
                <img src="../imagenesTienda/watermelons.jpg" ></a>
        </div>
       
    </main>
</body>
</html>