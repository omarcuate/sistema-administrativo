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

    $result = mysqli_query($conexion, "SELECT * FROM datos");
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

    <title>Aumento catrastral</title>
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
        <figure class="highcharts-figure">
        </figure>
        <div id="container-regression"></div>
        
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
      // Inicializar arrays para almacenar datos
      var categories = [];
      var regganeData = [];
      var tallinnData = [];

      <?php
      // Recorrer resultados de la consulta y almacenar datos en arrays
      while ($row = mysqli_fetch_array($result)) {
          echo "categories.push('" . $row["anio"] . "');";
          echo "regganeData.push(" . $row["valor"] . ");";
          echo "tallinnData.push(" . $row["valor2"] . ");";
      }
      ?>

      // Calcular la regresión lineal
      function calcularRegresion(data) {
          let sumX = 0;
          let sumY = 0;
          let sumXY = 0;
          let sumXX = 0;
          let count = data.length;

          for (let i = 0; i < count; i++) {
              sumX += i + 1;
              sumY += data[i];
              sumXY += (i + 1) * data[i];
              sumXX += (i + 1) * (i + 1);
          }

          let slope = (count * sumXY - sumX * sumY) / (count * sumXX - sumX * sumX);
          let intercept = (sumY - slope * sumX) / count;

          let regressionData = [];
          for (let i = 0; i < count; i++) {
              regressionData.push(slope * (i + 1) + intercept);
          }

          return regressionData;
      }

      // Obtener los datos de regresión para la serie 'actual'
      let regressionLineData = calcularRegresion(regganeData);

      // Crear el gráfico de Highcharts con los datos originales
      Highcharts.chart('container', {
          chart: {
              type: 'line'
          },
          title: {
              text: 'Grafica de analisis de tendencia de Aumento de Valor catastral (%)'
          },
          xAxis: {
              categories: categories
          },
          yAxis: {
              title: {
                  text: 'Aumento de Valor catastral (%)'
              }
          },
          plotOptions: {
              line: {
                  dataLabels: {
                      enabled: true
                  },
                  enableMouseTracking: false
              }
          },
          series: [{
              name: 'actual',
              data: regganeData
          }, {
              name: 'ajustes',
              data: tallinnData
          }]
      });

      // Crear el gráfico de Highcharts con la línea de regresión simple
      Highcharts.chart('container-regression', {
          chart: {
              type: 'scatter'
          },
          title: {
              text: 'Regresión Lineal Simple'
          },
          xAxis: {
              title: {
                  text: 'Año'
              },
              categories: categories
          },
          yAxis: {
              title: {
                  text: 'Aumento de Valor catastral (%)'
              }
          },
          series: [{
              name: 'Datos Originales',
              data: regganeData,
              marker: {
                  symbol: 'circle'
              }
          }, {
              name: 'Regresión Lineal',
              type: 'line',
              data: regressionLineData.map((value, index) => [index, value]),
              marker: {
                  enabled: false
              }
          }]
      });
    </script>
    <script type="text/javascript">
      window.addEventListener("scroll", function () {
        var header = document.querySelector("header");
        header.classList.toggle("abajo", window.scrollY > 0);
      });
    </script>
  </body>
</html>

<style>
    .graficas {
    display: flex; /* Hace que los elementos hijos se coloquen en línea */
    margin: 5%;
}

.highcharts-figure {
    flex: 1; /* Hace que cada figura ocupe el mismo espacio */
    margin: 5 10px; /* Añade un poco de espacio entre las figuras */
   max-width: 90%;
}

</style>