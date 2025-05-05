<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistemv_1";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el término de búsqueda desde la solicitud AJAX
$termino = $_GET['termino'];

// Consulta SQL para obtener datos de autocompletado
$sql = "SELECT DISTINCT clv_catastral, nomprop
FROM dbft05 WHERE clv_catastral LIKE '%$termino%'  OR nomprop LIKE '%$termino%' ";
$result = $conn->query($sql);

// Obtener los resultados y devolverlos como un array JSON
$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row['clv_catastral'];
        $data[] = $row['nomprop'];
    }
}

echo json_encode($data);

// Cerrar la conexión
$conn->close();
?>