<?php
// Configuración de la base de datos
include('../config/conexion.php');
 

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}
  
// Eliminar un registro
 
if (isset($_POST['eliminar'])) {
 
    $id = $_POST['eliminar_id'];
 
 
 
    $sql = "DELETE FROM usuarios WHERE id = $id";
 
    $conexion->query($sql);
 
}
// Obtener todos los registros de la tabla
$result = $conexion->query("SELECT * FROM usuarios");
 
// Cerrar la conexión a la base de datos
$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Usuarios</title>
<link rel="stylesheet" href="../css/style_adm.css">
<link rel="stylesheet" href="../css/usuario.css">
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>

<div class="user-info">
    <button onclick="location.href='../config/salir.php';" class="logout-button">Salir</button>
    <span>ADS</span>
</div>

<nav>
    <ul>
       <center> <li><strong>Dashboard</strong></li></center>
       <br>
        <li><ion-icon name="speedometer"></ion-icon>      <a href="index.php">Inicio</a></li>
        <li><ion-icon name="pie-chart"></ion-icon>        <a href="graficas.php">Graficas</a></li>
        <li><ion-icon name="file-tray-stacked"></ion-icon><a href="tablas.php">Tablas CRUDS</a></li>
        <li><ion-icon name="person-add"></ion-icon>       <a href="usuarios.php">Usuarios</a></li>
        <li><ion-icon name="aperture"></ion-icon>         <a href="../pages/index.php">Web site</a></li>
        <li><ion-icon name="terminal"></ion-icon>             <a href="consola.php">Consola</a></li>
    </ul>
</nav>
<h1>
   

<div class="content-box">

<div class="form-register">
<center><ion-icon name="person-circle-outline" class="user"></ion-icon > </center>
<style>
.user{
width: 190px;
height: 70px;
}
</style>
      <form action="action/registro-new-user.php" method="post" enctype="multipart/from-data">

        <input class="controls" type="text" name="apellidoP" placeholder="ApellidoP">
        <input class="controls" type="text" name="apellidoM" placeholder="ApellidoM">
        <input class="controls" type="text" name="nombres" placeholder="Nombre(s)">
        <input class="controls" type="text" name="email" placeholder="User">
        <input class="controls" type="password" name="clave" placeholder="Contrase&ntilde;a">
        <select class="controls" name="tipo_usuario">
                    <option value="Comun">Comun</option>
                    <option value="Admin">Admin</option>
                </select>
        <input class="botons" type="submit" name="register" value="Enviar">
      </form>
    </div>

</div>
<div class="content-box">
<center><h1>Usuarios</h1></center>
    
    <!-- Tabla deusuarios -->
    <table >
        <thead>
            <tr>
                <th>ID</th>
                <th>ApellidoP</th>
                <th>ApellidoM</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>usuario</th>
                <th>Eliminar</th>
                <th>Privilegios</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['apellidoP']; ?></td>
                    <td><?php echo $row['apellidoM']; ?></td>
                    <td><?php echo $row['nombres']; ?></td> 
                    <td><?php echo $row['email']; ?></td> 
                    <td><?php echo $row['tipo_usuario']; ?></td> 
                    <td>
 
<form method="post" action="">
 
    <input class="eliminar" type="hidden" name="eliminar_id" value="<?php echo $row['id']; ?>">
 
    <button class="eliminar" type="submit" name="eliminar">Eliminar</button></form></td>

    <td> <a href="action/edit-user.php?id=<?php echo $row['id']; ?>" class="nuevo">Editar</a></td>
 
          
                </tr>
            <?php endwhile; ?>
        </tbody>

</div>

</body>
</html>
