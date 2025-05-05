<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/style_cm.css">
    <link rel="stylesheet" href="../../css/buscar-data.css">
</head>
<body>
<header>
    <div>
        <nav class="navegacion">
            <ul class="menu">
                <li><a href="index.php">Inicio</a></li>
                <li><a>Graficos</a>
                    <ul class="submenu">
                        <li><a> Tablas</a></li>
                        <li><a> Graficas</a></li>
                    </ul>
                </li>
                <li><a>Funciones</a>
                    <ul class="submenu">
                        <li><a> Calculas Claves</a></li>
                        <li><a> Convertidor SQL</a></li>
                        <li><a> Limpieza de datos</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>

    <nav class="navegacion">
        <div>
            <ul class="menu2">
                <li><a href="..\login/login/salir.php"> Cerrar sesión</a></li>
            </ul>
        </div>
    </nav>
</header>
<section class="zona1 box box4 shadow4">
<h1>los resultados son</h1>

<?php
// Conexión a la base de datos
$servidor = "localhost";
$usuario = "root";
$password = "";
$db = "sistemv_1";
$conexion = new mysqli($servidor, $usuario, $password, $db);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Obtener el término de búsqueda
$termino = $_POST['termino'];

// Consulta SQL para buscar registros
$sql = "SELECT * FROM dbft05 WHERE clv_catastral LIKE '%$termino%' OR municipio LIKE '%$termino%'
        OR zona LIKE '%$termino%' OR manzana LIKE '%$termino%' OR lote LIKE '%$termino%' OR Lote LIKE '%$termino%'
        OR nomprop LIKE '%$termino%' OR rfc LIKE '%$termino%' OR domfis LIKE '%$termino%' OR curp LIKE '%$termino%'
        ";

$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr>
            <th>Clave Catastral</th>
            <th>Municipio</th>
            <th>Zona</th>
            <th>Manzana</th>
            <th>Lote</th>
            <th>Propietario</th>
            <th>RFC</th>
            <th>Domicilio Fiscal</th>
            <th>CURP</th>
         </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['clv_catastral'] . "</td>
                <td>" . $row['municipio'] . "</td>
                <td>" . $row['zona'] . "</td>
                <td>" . $row['manzana'] . "</td>
                <td>" . $row['lote'] . "</td>
                <td>" . $row['nomprop'] . "</td>
                <td>" . $row['rfc'] . "</td>
                <td>" . $row['domfis'] . "</td>
                <td>" . $row['curp'] . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No se encontraron resultados.</p>";
}

// Cerrar la conexión
$conexion->close();
?>
</section>
</body>
</html>
