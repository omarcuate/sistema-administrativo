<?php
// Conexión a la base de datos
include('../config/conexion.php');
// Obtener el término de búsqueda desde la solicitud AJAX
$termino = $_GET['termino'];

// Consulta SQL para obtener datos de autocompletado por nombre de municipio
$sql = "SELECT id_municipio, municipio FROM municipios WHERE municipio LIKE '%$termino%' OR id_municipio LIKE '%$termino%'";
$resultado = $conexion->query($sql);

// Obtener los resultados y devolverlos como un array JSON
$datos = array();
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $datos[] = $fila;
    }
}

echo json_encode($datos);

// Cerrar la conexión
$conexion->close();
?>
