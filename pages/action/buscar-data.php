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
    <div >
        <form action="buscar-registro.php" method="post" class="formulario">
            <label for="termino"></label>
            <input type="text" id="termino" name="termino" required placeholder="Buscar">
            <button type="submit">Buscar</button>
        </form>
        <!-- Contenedor para mostrar resultados de autocompletado -->
        <div id="autocomplete-results"></div>
    </div>

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

    // Obtener el término de búsqueda
    $termino = $_POST['termino'];

    // Consulta SQL para buscar registros
    $sql = "SELECT * FROM dbft05 WHERE municipio LIKE '%$termino%'";

    $result = $conn->query($sql);

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
    $conn->close();
    ?>
</section>
<script src="../js/scriptregis.js">  </script>
</body>
</html>

<style>
    #autocomplete-results {
        position: absolute;
        width: 10%;
        background-color: #fff;
        border: 1px solid #ccc;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: none;
    }

    #autocomplete-results li {
        list-style: none;
        padding: 8px;
        cursor: pointer;
    }

    #autocomplete-results li:hover {
        background-color: #f5f5f5;
    }
</style>
