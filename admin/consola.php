<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/consola.css">
    <link rel="stylesheet" href="../css/style_adm.css">
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
    <div class="content-box">
    <h2>Consulta SQL</h2>
    <form action="action/ejecutar_consulta.php" method="post">
        <textarea name="consulta" placeholder="Introduce tu consulta SQL aquí..." rows="5" cols="50"></textarea><br><br>
        <input type="submit" value="Ejecutar Consulta">
    </form>
    </div>
</body>
</html>
