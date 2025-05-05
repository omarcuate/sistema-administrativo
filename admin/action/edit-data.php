<?php
// este es el editar de la tabla t05

// Verifica si se ha pasado un CLV Catastral válido a través de la URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $clv_catastral = $_GET['id']; // Obtén el CLV Catastral de la URL
    
    // Conecta a la base de datos
    $conexion = new mysqli('localhost', 'root', '', 'sistemv_1');
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    
    // Consulta SQL para obtener los datos del registro a editar
    $sql = "SELECT * FROM dbft05 WHERE clv_catastral = '$clv_catastral'";
    $result = $conexion->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Aquí puedes mostrar un formulario con los datos actuales del registro para que el usuario los edite
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
 <center> <h1>Editar Registro</h1></center> 
   
<div class="container">

<body>
         
            <form action="guardar_edicion.php" method="post" class="edit-form">
                <input type="hidden" name="clv_catastral" value="<?php echo $row['clv_catastral']; ?>">

                <label for="clv_catastral">Clave Catastral:</label>
                <input type="text" id="clv_catastral" name="clv_catastral" value="<?php echo $row['clv_catastral']; ?>">

                <label for="municipio">Municipio:</label>
                <input type="text" id="municipio" name="municipio" value="<?php echo $row['municipio']; ?>">

                <label for="municipio">Zona:</label>
                <input type="text" id="municipio" name="zona" value="<?php echo $row['zona']; ?>">

                <label for="manzana">Manzana:</label>
                <input type="text" id="manzana" name="manzana" value="<?php echo $row['manzana']; ?>">

                <label for="lote">Lote:</label>
                <input type="text" id="lote" name="lote" value="<?php echo $row['lote']; ?>">

                <label for="nomprop">nomprop:</label>
                <input type="text" name="nomprop" value="<?php echo $row['nomprop']; ?>">

                <label for="rfc">rfc:</label>
                <input type="text" name="rfc" value="<?php echo $row['rfc']; ?>">

                <label for="domfis">domfis:</label>
                <input type="text" name="domfis" value="<?php echo $row['domfis']; ?>">

                <label for="curp">curp:</label>
                <input type="text" name="curp" value="<?php echo $row['curp']; ?>">

                <input type="submit" value="Actualizar">
                <a href="editdata.php" class="regresar">Regresar</a>
            </form>
        </body>
</div>

</div>

        </html>
        <?php
    } else {
        echo "No se encontró ningún registro con el CLV Catastral proporcionado.";
    }
    
    $conexion->close();
} else {
    // Si no se proporcionó un CLV Catastral válido, redirige al usuario a alguna otra página o muestra un mensaje de error
    echo "CLV Catastral no válido";
}
?>

     <style>
        /* Estilos para el contenido */
       
       
        h1 {
            text-align: center;
        }

        /* Estilos para el formulario */
        .edit-form {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            grid-gap: 10px;
        }
        .form-row {
            grid-column: span 2;
        }
        label {
            font-weight: bold;
            margin: 10px;
        }
        input[type="text"] {
            width: calc(100% - 12px);
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            height: 50px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .regresar{
            max-height: 50px;   
            padding: 15px;
            background-color:#5DADE2;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            text-align: center;
            align-items: center;
        }
    </style>
</style> 
