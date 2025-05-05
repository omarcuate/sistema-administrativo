<?php
// Verifica si se ha pasado un CLV Catastral válido a través de la URL
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $clv_catastral = $_GET['id']; // Obtén el CLV Catastral de la URL
    
    // Conecta a la base de datos
    $conexion = new mysqli('localhost', 'root', '', 'sistemv_1');
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    
    // Consulta SQL para eliminar el registro con el CLV Catastral proporcionado
    $sql = "DELETE FROM dbft05 WHERE clv_catastral = '$clv_catastral'";
    
    // Ejecuta la consulta
    if ($conexion->query($sql) === TRUE) {
        echo "El registro con CLV Catastral $clv_catastral ha sido eliminado correctamente.";
    } else {
        echo "Error al eliminar el registro: " . $conexion->error;
    }
    
    $conexion->close();
} else {
    // Si no se proporcionó un CLV Catastral válido, redirige al usuario a alguna otra página o muestra un mensaje de error
    echo "CLV Catastral no válido";
}
?>
