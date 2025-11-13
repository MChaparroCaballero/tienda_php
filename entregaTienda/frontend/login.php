<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/login.css">
    </head>
<body>
    
    <div id="contenedorFormulario">
    <form action="../backend/iniciarSesion.php"  method="post">
        <div class="campo">
        <label for="gmailUsuario">USUARIO:</label>
        <input type="text" id="gmailUsuario" name="gmail">
        </div>
        <div class="campo">
        <label for="claveUsuario">CONTRASEÑA:</label>
        <input type="password" id="claveUsuario" name="clave">
        </div>
        <button type="submit">Iniciar sesión</button>
    </form>
    </div>
</body>
</html>