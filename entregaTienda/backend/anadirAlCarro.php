<?php

session_start(); // Aseguramos que la sesión esté iniciada
require_once 'conectar.php'; // Tu conexión PDO
// require_once 'sesiones.php'; // Si tu comprobar_sesion inicia la sesión, puedes comentarla
// comprobar_sesion(); // Comprobar que el usuario está logueado y maneja redirección



// Alias para el objeto PDO
$pdo = $bd; 

// --- 2. VALIDACIÓN DE SESIÓN Y DATOS POST ---
// Verifica que el usuario esté logueado y que los datos POST esenciales existan
if (!isset($_SESSION['usuario']) || !isset($_SESSION['carrito'])) {
    header('Location: ../frontend/login.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] != "POST" || !isset($_POST['producto_id'], $_POST['cantidad'])) {
    // Si la solicitud no es POST o faltan datos, redirige
    header('Location: /ruta/a/error.php'); 
    exit;
}

// 3. RECUPERAR DATOS DEL FORMULARIO Y SESIÓN
$usuario_id = (int)$_SESSION['usuario']['id']; // ID del usuario logueado
$producto_id = $_POST['producto_id']; // ID o código del producto
$cantidad_a_comprar = (int)$_POST['cantidad']; // Unidades

// Validación simple de que si no me pasas cantidad te vuelves al detalle
if ($cantidad_a_comprar <= 0) {
    header('Location: ../frontend/detalleProducto.php?id=' . $producto_id . '&error=cantidad_invalida');
    exit;
}

//obtenemos el nombre y precio del producto que se pretende añadir para poder posteriormente multiplicarlo por la cantidad de unidades que se planea añadir al carro
$sql_producto = "SELECT Nombre, Precio FROM productos WHERE CodProd = ?";
$stmt_producto = $pdo->prepare($sql_producto);
$stmt_producto->execute(array($producto_id));
$producto_data = $stmt_producto->fetch();

if (!$producto_data) {
    throw new Exception ("Producto no encontrado");
}

$nombre_producto = $producto_data['Nombre'];
$precio_unitario = (float)$producto_data['Precio'];


// --- 4. GESTIÓN DE LA CABECERA DEL CARRITO EN LA BD (Tabla: carro) ---

$cod_carro_sesion = $_SESSION['carrito']['CodCarro'];

if ($cod_carro_sesion === null) {
    // Es el primer producto: hay que crear la cabecera 'carro'
    
    $fecha = $_SESSION['carrito']['fecha']; // Fecha del login (Y-m-d)
    $estado = $_SESSION['carrito']['estado']; // 0 (e.g., Pendiente)

    try {
        // A. Insertar Cabecera en la tabla 'carro'
        // Asumo que tu tabla 'carro' tiene campos para el id, fecha, y estado
        $sql_cabecera = "INSERT INTO carro ( Fecha, enviado) VALUES (?,?)";
        $stmt_cabecera = $pdo->prepare($sql_cabecera);
        $stmt_cabecera->execute(array($fecha,$estado));

        // B. Obtener el CodCarro autoincrementado
        $nuevo_cod_carro = $pdo->lastInsertId();

        // C. Guardamos el codigo del maldito carro que le puso la bd
        $_SESSION['carrito']['CodCarro'] = $nuevo_cod_carro;
        $cod_carro_bd = $nuevo_cod_carro;

    } catch (PDOException $e) {
        die("Error al crear la cabecera del carrito: " . $e->getMessage());
    }
} else {
    // Ya existe: usar el CodCarro que está en la sesión
    $cod_carro_bd = $cod_carro_sesion;
}

// --- 5. GESTIÓN DEL DETALLE DEL CARRITO EN LA BD (Tabla: detalle_carrito) ---

// A. Verificar si el producto ya está en el detalle para este carrito
$sql_check = "SELECT CodCarroProd,CodCarro,CodProd,Unidades FROM carroproductos WHERE CodCarro = ? AND CodProd = ?";
$stmt_check = $pdo->prepare($sql_check);
$stmt_check->execute(array($cod_carro_bd,$producto_id ));
//alamcenamos los resultados de la consulta//
$detalle_existente = $stmt_check->fetch();



//actualizamos el ticket de detalle de carroo en la bd//
try {
    if ($detalle_existente) {
        // Producto ya existe: Actualizar Cantidad
        $nueva_a_comprar = $cantidad_a_comprar + $detalle_existente['Unidades'];
        $cod_detalle = $detalle_existente['CodCarroProd'];
        $nuevo_precio_sql=$precio_unitario*$nueva_a_comprar;
        $sql_update = "UPDATE carroproductos SET Unidades = ? , total= ? WHERE CodCarroProd = ?";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute(array($nueva_a_comprar,$nuevo_precio,$cod_detalle));

    } else {
        $nuevo_precio=$precio_unitario*$cantidad_a_comprar;
        // Producto NO existe: Insertar Nuevo Detalle
        $sql_insert_detalle = "INSERT INTO carroproductos (CodCarro,CodProd,Unidades,total) 
                               VALUES (?, ?, ?, ?)";
        $stmt_insert = $pdo->prepare($sql_insert_detalle);
        $stmt_insert->execute(array($cod_carro_bd,$producto_id,$cantidad_a_comprar,$nuevo_precio));
    }

} catch (PDOException $e) {
    die("Error al gestionar el detalle del carrito: " . $e->getMessage());
}


// --- 6. ACTUALIZAR EL ARRAY DE PRODUCTOS EN LA SESIÓN (Para la UI) ---

$encontrado = false;
foreach ($_SESSION['carrito']['productos'] as $clave => $item) {
    if ($item['CodProd'] === $producto_id) {
        $_SESSION['carrito']['productos'][$clave]['Unidades'] += $cantidad_a_comprar;
        $encontrado = true;
        break;
    }
}

if (!$encontrado) {
    // Añadir el nuevo ítem al array 'productos' de la sesión
    $_SESSION['carrito']['productos'][] = [
        'CodProd'  => $producto_id,
        'nombre'   => $nombre_producto,
        'Unidades' => $cantidad_a_comprar,
        'precio'   => $nuevo_precio
    ];
}


// 7. REDIRECCIÓN FINAL
header('Location: carrito.php');
exit;
?>