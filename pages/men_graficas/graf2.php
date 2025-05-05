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
$result = $conexion->query("SELECT * FROM recaudacion");
if (!$result) {
    die("Error en la consulta: " . $conexion->error);
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
    <title>Total de cuentas CCTS</title>
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
    <div id="container-column"></div>
</figure>

<figure class="highcharts-figure">
    <div id="container-area"></div>
</figure> 

</div>
<script type="text/javascript">
    // Crear el gráfico de columnas
    Highcharts.chart('container-column', {
        chart: {
            type: 'column'
        },
        title: {
            align: 'left',
            text: 'Total de CCs'
        },
        subtitle: {
            align: 'left',
            text: 'Total de cuentas catastrales'
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Total'
            },
            min: 0,
            max: 3500
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}$'
                }
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>'
        },
        series: [
            {
                name: 'Recaudacion',
                colorByPoint: true,
                data: [
                    <?php
                    $acumulado = 0;
                    while ($row = $result->fetch_assoc()) {
                        $acumulado += $row["total_cuentas_catastrales"];
                        echo "{ name: '" . $row["fechas"] . "', y: " . $row["total_cuentas_catastrales"] . " },";
                    }
                    ?>
                ]
            },
            {
                name: 'Recaudacion Acumulada',
                color: 'gray',
                type: 'spline',
                data: [
                    <?php
                    $result->data_seek(0);
                    $acumulado = 0;
                    while ($row = $result->fetch_assoc()) {
                        $acumulado += $row["total_cuentas_catastrales"];
                        echo "{ name: '" . $row["fechas"] . "', y: " . $acumulado . " },";
                    }
                    ?>
                ]
            }
        ],
        drilldown: {
            breadcrumbs: {
                position: {
                    align: 'right'
                }
            },
            series: [{
                type: 'pie',
                name: 'Total venta',
                data: [
                    <?php
                    $result->data_seek(0);
                    while ($row = $result->fetch_assoc()) {
                        echo "['" . $row["fechas"] . "'," . $row["total_cuentas_catastrales"] . "],";
                    }
                    ?>
                ]
            }]
        }
    });

    // Crear el gráfico de área para la recaudación acumulada
    Highcharts.chart('container-area', {
        chart: {
            type: 'area'
        },
        title: {
            align: 'left',
            text: 'RECAUDACION'
        },
        subtitle: {
            align: 'left',
            text: 'total cuentas catastrales'
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Total'
            },
            min: 0,
            max: <?php echo $acumulado; ?>
        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}$'
                }
            }
        },
        series: [
            {
                name: 'Recaudacion Acumulada',
                colorByPoint: true,
                data: [
                    <?php
                    $result->data_seek(0);
                    $acumulado = 0;
                    while ($row = $result->fetch_assoc()) {
                        $acumulado += $row["total_cuentas_catastrales"];
                        echo "{ name: '" . $row["fechas"] . "', y: " . $acumulado . " },";
                    }
                    ?>
                ]
            }
        ],
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}$</b><br/>'
        }
    });
</script>

    <section class="paginacion">
        <ul>
          <li><a href="graf.php" class="active">1</a></li>
          <li><a href="graf2.php">2</a></li>
          <li><a href="graf3.php">3</a></li>
          <li><a href="graf4.php">4</a></li>
        </ul>
      </section>
    </section>
    </body>
</html>
<style>
    .graficas {
    display: flex; /* Hace que los elementos hijos se coloquen en línea */
}

.highcharts-figure {
    flex: 1; /* Hace que cada figura ocupe el mismo espacio */
    margin: 0 10px; /* Añade un poco de espacio entre las figuras */
width: 30px;
}

</style>