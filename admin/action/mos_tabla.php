<?php
// Incluye el archivo de conexión
include('../../config/conexion.php');

$amount = isset($_GET['amount']) ? $_GET['amount'] : 25;

// Consulta SQL para obtener los datos
$sql = "SELECT * FROM dbft05";
if ($amount > 0 && $amount != 'all') {
    $sql .= " LIMIT $amount";
}

$result = $conexion->query($sql);

// Comprueba si hay filas devueltas por la consulta
if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>clave</th>
                <th>municipio</th>
                <th>zona</th>
                <th>manzana</th>
                <th>lote</th>
                <th>nomprop</th>
                <th>rfc</th>
                <th>domfis</th>
                <th>curp</th>
                </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['clv_catastral'] . "</td>";
                    echo "<td>" . $row['municipio'] . "</td>";
                    echo "<td>" . $row['zona'] . "</td>";
                    echo "<td>" . $row['manzana'] . "</td>";
                    echo "<td>" . $row['lote'] . "</td>";
                    echo "<td>" . $row['nomprop'] . "</td>";
                    echo "<td>" . $row['rfc'] . "</td>";
                    echo "<td>" . $row['domfis'] . "</td>";
                    echo "<td>" . $row['curp'] . "</td>";
                    echo "</tr>";
    }
    echo "</table>";
}
 else {
    echo "<tr><td colspan='6'>No hay datos disponibles</td></tr>";
}

// Cierra la conexión a la base de datos
$conexion->close();
?>
