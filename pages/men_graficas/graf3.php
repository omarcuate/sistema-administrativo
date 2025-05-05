<?php
session_start();

if (!isset($_SESSION['email'])) {
    echo '
        <script>
            alert("por favos inicie sesión")
            window. location = "../index.html";
        </script>

        ';
    session_destroy();
    die();
}
?>
<?php
include('../../config/conexion.php');

$result = mysqli_query($conexion, "SELECT * FROM porcentual");
if (!$result) {
    die('Error al ejecutar la consulta: ' . mysqli_error($conexion));
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../../css/style_cm.css" />
    <link rel="stylesheet" href="../../css/pagination.css">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <title>RECAUDACION EN MMD</title>
    <link rel="icon" type="img" href="../../media/colibri.svg" />
  </head>
  <body>
    <header>
      <div>
        <nav class="navegacion">
          <ul class="menu">
            <li><a href="../index.php">Inicio</a></li>
            <li>
              <a>Graficos</a>
              <ul class="submenu">
                <li><a href="../tablas.php"> Tablas</a></li>
                <li><a href="graf4.php"> Graficas</a></li>
              </ul>
            </li>
            <li>
              <a>Funciones</a>
              <ul class="submenu">
                            <li><a href="http://127.0.0.1:5000"> Calculas Claves</a></li>
                            <li><a href="http://127.0.0.1:5000/sqls"> Convertidor SQL</a></li>
                            <li><a href="http://127.0.0.1:5000/limpieza"> Limpieza de datos</a></li>
                        </ul>
            </li>
          </ul>
        </nav>
      </div>

      <nav class="navegacion">
        <div>
          <ul class="menu2">
            <li><a href="../../config/salir.php"> Cerrar sesión</a></li>
          </ul>
        </div>
      </nav>
    </header>

    <section class="zona1 box box4 shadow4">
    <div class="graficas">
    <figure class="highcharts-figure">
    <div id="container"></div>
</figure>
</div>
    <section class="paginacion">
        <ul>
          <li><a href="graf.php" class="active">1</a></li>
          <li><a href="graf2.php">2</a></li>
          <li><a href="graf3.php">3</a></li>
          <li><a href="graf4.php">4</a></li>
        </ul>
      </section>
    </section>

    <script type="text/javascript">

Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'RECAUDACION',
        align: 'left'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
                type: 'pie',
                name: 'Total venta',
                data: [
                    <?php
                    // Reiniciamos el cursor de la consulta
                    mysqli_data_seek($result, 0);
                    while ($row = mysqli_fetch_array($result)) {
                        echo "['" . $row["tipo"] . "'," . $row["valor"] . "],";
                    }
                    ?>
                ]
    }]
});

		</script>   
    </body>
</html>
