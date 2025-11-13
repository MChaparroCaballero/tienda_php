<?php
function obtenerDetalleProducto($id, $bd) {
    
    // Convertir a entero para seguridad adicional (aunque el prepared statement ayuda)
    $producto_id = (int)$id; 

    // Usar Prepared Statements para prevenir Inyección SQL
    $sql = "SELECT Nombre, Descripcion, Precio, Cantidad, CodCat FROM productos WHERE CodProd = ?";

    if ($stmt = $bd->prepare($sql)) {
        $stmt->execute(array($producto_id));
        $resultado = $stmt->fetch();
        
        // Devolver el array asociativo del producto encontrado
        return $resultado;
        
    } else {
        // En un entorno real, aquí registrarías el error
        return null;
    }
}


?>