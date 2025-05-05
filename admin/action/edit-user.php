<?php
include('../../config/conexion.php');
 
if(isset($_POST['enviar'])){
    // Aquí entra cuando se presiona el botón enviar
    $ID = $_POST['id'];
    $pampellido = $_POST["apellidoP"];
    $mapellido = $_POST["apellidoM"];
    $name = $_POST["nombres"];
    $email = $_POST["email"];
    $user = $_POST["tipo_usuario"];
 
    $sql = "UPDATE usuarios SET apellidoP='$pampellido', apellidoM='$mapellido', nombres='$name', email='$email', tipo_usuario='$user' WHERE id='$ID'";
 
    $result = mysqli_query($conexion, $sql);
 
    if($result){
        echo "<script language='javaScript'>
        alert('Los datos se han actualizado');
        location.assign('../usuarios.php');
        </script>";
    }else{
        echo "<script language='javaScript'>
        alert('Los datos NO se han actualizado');
        location.assign('../usuarios.php');
        </script>";
    }
 
} else {
    // Aquí entra si no se presiona el botón enviar
    if(isset($_GET['id'])) {
        $ID = $_GET['id'];
        $sql = "SELECT * FROM usuarios WHERE id='$ID'";
        $mostrar = mysqli_query($conexion, $sql);
 
        if($mostrar && mysqli_num_rows($mostrar) > 0) {
            $filas = mysqli_fetch_assoc($mostrar);
            $pampellido = $filas["apellidoP"];
            $mapellido = $filas["apellidoM"];
            $name = $filas["nombres"];
            $email = $filas["email"];
            $user = $filas["tipo_usuario"];
        } else {
            // Si no se encuentra el usuario, podrías manejar una redirección o mostrar un mensaje de error
            echo "<script language='javaScript'>
            alert('Usuario no encontrado');
            location.assign('../usuarios.php');
            </script>";
            exit(); // Sale del script si no se encontró el usuario
        }
    } else {
        // Si no se proporciona un ID válido, podrías manejar una redirección o mostrar un mensaje de error
        echo "<script language='javaScript'>
        alert('ID de usuario no proporcionado');
        location.assign('../usuarios.php');
        </script>";
        exit(); // Sale del script si no se proporciona un ID válido
    }
}
 
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Usuario</title>
<link rel="stylesheet" href="../../css/style_adm.css">
<link rel="stylesheet" href="../../css/edit-user.css">
<script src="https://code.jscharting.com/latest/jscharting.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
</head>
<body>

<div class="user-info">
    <button onclick="location.href='../../config/salir.php';" class="logout-button">Salir</button>
    <span>ADS</span>
</div>

<nav>
    <ul>
       <center> <li><strong>Dashboard</strong></li></center>
       <br>
        <li><ion-icon name="speedometer"></ion-icon>      <a href="../index.php">Inicio</a></li>
        <li><ion-icon name="pie-chart"></ion-icon>        <a href="../graficas.php">Graficas</a></li>
        <li><ion-icon name="file-tray-stacked"></ion-icon><a href="../tablas.php">Tablas CRUDS</a></li>
        <li><ion-icon name="person-add"></ion-icon>       <a href="../registro.php">Usuarios</a></li>
        <li><ion-icon name="aperture"></ion-icon>         <a href="../../pages/index.php">Web site</a></li>
    </ul>
</nav>

<div class="content-box">
  <center> <h1><ion-icon name="create-sharp"></ion-icon>Editar</h1></center> 

  <div class="form-container">
 
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
       <label>Apellido Paterno:</label><br>
       <input type="text" name="apellidoP" value="<?php echo $pampellido;?>"><br>
 

       <label>Apellido Materno:</label><br>
       <input type="text" name="apellidoM" value="<?php echo $mapellido;?>"><br>
 
       <label>Nombre:</label><br>
       <input type="text" name="nombres" value="<?php echo $name;?>"><br>

       <label>Email:</label><br>
       <input type="text" name="email" value="<?php echo $email;?>"><br>

       <label>Tipo Usuario:</label><br>
       <input type="text" name="tipo_usuario" value="<?php echo $user;?>"><br>
 
       <input type="hidden" name="id" value="<?php echo $ID;?>"><br>
       <button class="actualizar" type="submit" name="enviar">Actualizar</button>
       <a href="../usuarios.php" class="regresar">Regresar</a>
    </form>
</div>

</div>

</body>
</html>
