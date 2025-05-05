<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../css/login.css">
  <title>iniciar sesión</title>
</head>

<body>
    <div class="form-register">
      <img class="logo" src="..\media/logo.svg" alt="">
  
      <form action="../config/validacion.php" method="POST">
        <label for="email">Usuario:</label>
        <input class="controls" type="text" name="email" id="email">
    
        <label for="contrasena">Ingrese su Contraseña:</label>
        <input class="controls" type="password" name="contrasena" id="contrasena">
    
        <input class="botons" type="submit" value="Ingresar">
      </form>
    </div>
</body>

</html> 
