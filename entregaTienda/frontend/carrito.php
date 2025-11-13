<!DOCTYPE html>
<html>
	<head>
		<meta charset = "UTF-8">
		<title>Carrito de la compra</title>		
	</head>
	<body>
		
		<?php 
			require_once 'sesiones.php';
			require_once 'conectar.php';
			comprobar_sesion();

			$codigoCarro = 1;
			function cargar_carro($bd , $codigoCarro){
			$ins = $bd->prepare("select CodCarro, CodProd, Unidades from carroproductos where CodCarro = ?");
			$resul=$ins->execute(array($codigoCarro));
			echo "<h2>Carrito de la compra</h2>";
			echo "<table>"; //abrir la tabla
			echo "<tr><th>Nombre</th><th>Descripción</th><th>Peso</th><th>Unidades</th><th>Eliminar</th></tr>";
			foreach($resul as $carro){
				$codProducto=$carro['CodProd'];
				$unidades= $carro['Unidades'];
				echo "".cargar_producto($codProducto)."";
			}
			}

			function cargar_producto($bd , $codProducto,$unidades){
				$linea = "";
				$ins = $bd->prepare("select Nombre, precio from productos where CodProd = ?");
				$resul=$ins->execute(array($codProducto));
				foreach($resul as $producto){
					$nom = $producto['Nombre'];
					$precio = $producto['Precio'];
					$linea="<tr><td>$nom</td><td>$precio</td><td>$unidades</td>";
				}
				return linea;
			}		
	?>
		<hr>
		<a href = "procesar_pedido.php">Realizar pedido</a>		
	</body>
</html>