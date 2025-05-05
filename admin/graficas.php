<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Graficas</title>
<!-- Enlaces a archivos CSS -->
<link rel="stylesheet" href="../css/style_adm.css">
<link rel="stylesheet" href="../css/graficas.css">
<!-- Enlaces a archivos JavaScript -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jscharting.com/latest/jscharting.js"></script>
<script type="text/javascript" src="https://code.jscharting.com/latest/modules/types.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
</head>
<body>
<div class="user-info">
    <button onclick="location.href='../config/salir.php';" class="logout-button">Salir</button>
    <span>ADS</span>
</div>

<nav>
    <ul>
       <center> <li><strong>Dashboard</strong></li></center>
       <br>
        <li><ion-icon name="speedometer"></ion-icon>      <a href="index.php">Inicio</a></li>
        <li><ion-icon name="pie-chart"></ion-icon>        <a href="graficas.php">Graficas</a></li>
        <li><ion-icon name="file-tray-stacked"></ion-icon><a href="tablas.php">Tablas CRUDS</a></li>
        <li><ion-icon name="person-add"></ion-icon>       <a href="usuarios.php">Usuarios</a></li>
        <li><ion-icon name="aperture"></ion-icon>         <a href="../pages/index.php">Web site</a></li>
        <li><ion-icon name="terminal"></ion-icon>             <a href="consola.php">Consola</a></li>
    </ul>
</nav>
<!-- Título de la página -->
<center><h1><ion-icon name="bar-chart"></ion-icon>Graficas</h1></center><br>
<div class="content-box">
    <!-- Enlace para refrescar la página -->
    <a href="graficas.php"><img src="https://cdn-icons-png.flaticon.com/512/560/560512.png" alt=""class="refresco"></a>
   
   <?php
   // Incluir archivo de conexión a la base de datos
   include('../config/conexion.php');
   // Consulta SQL para obtener datos
   $conexion = mysqli_query($conexion, "SELECT * FROM datos");
   // Manejo de errores
   if (!$conexion) {
       die('Error al ejecutar la consulta: ' . mysqli_error($link));
   }
   ?>
   <!-- Gráfico de líneas -->
   <figure class="highcharts-figure">
       <div id="container"></div>
       <!-- Botón para editar -->
       <button class="btn1" onclick="openModal('modal1')">Editar</button>
   </figure>
   <!-- Script para generar el gráfico -->
   <script type="text/javascript">
       // Inicializar arrays para almacenar datos
       var categories = [];
       var regganeData = [];
       var tallinnData = [];

       <?php
       // Recorrer resultados de la consulta y almacenar datos en arrays
       while ($row = mysqli_fetch_array($conexion)) {
           echo "categories.push('" . $row["anio"] . "');";
           echo "regganeData.push(" . $row["valor"] . ");";
           echo "tallinnData.push(" . $row["valor2"] . ");";
       }
       ?>

       // Crear el gráfico de Highcharts
       Highcharts.chart('container', {
           chart: {
               type: 'line'
           },
           title: {
               text: 'Gráfica de análisis de tendencia de Aumento de Valor catastral (%)'
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
   </script>

   <!-- Gráfico de dona -->
   <div class="porcentual"> 
       <div class="relativo">
           <button class="btn2" onclick="openModal('modal2')">Editar</button>
       </div>
       <canvas id="myChart" class="circulo"></canvas>

       <?php
       include('../config/conexion.php');
       // Consulta para obtener los datos de la tabla correspondiente
       $result = $conexion->query("SELECT tipo, valor FROM porcentual");
       // Recorre los resultados y almacena los datos en arreglos
       $labels = [];
       $data = [];
       while ($row = $result->fetch_assoc()) {
           $labels[] = $row['tipo'];
           $data[] = $row['valor'];
       }
       ?>
       <!-- Script para generar el gráfico -->
       <script>
           var ctx = document.getElementById('myChart').getContext('2d');
           var myChart = new Chart(ctx, {
               type: 'doughnut',
               data: {
                   labels: <?php echo json_encode($labels); ?>,
                   datasets: [{
                       data: <?php echo json_encode($data); ?>,
                       backgroundColor: ['#950000', '#480101d7'],
                       borderWidth: 1
                   }]
               }
           });
       </script>
   </div>

   <!-- Gráfico de velocímetro -->
   <?php
   // Consulta para obtener el porcentaje desde la base de datos
   $result = $conexion->query("SELECT valor FROM porcentual WHERE tipo = 'Porcentaje de Recaudación'");
   // Obtiene el valor del porcentaje
   $porcentaje = $result->fetch_assoc()['valor'];
   ?>
   <div id="chartDiv1" class="vel">
   </div>
   <script>
       // JS 
       var value = Math.round(Math.random() * 100); 
       var chart1 = JSC.chart( 
           'chartDiv1', 
           JSC.merge(defaultOptions(), { 
               defaultPoint: { 
                   marker: { 
                       outline: { 
                           width: 5, 
                           color: 'currentColor'
                       }, 
                       rotate: 'auto', 
                       type: 'triangle', 
                       size: 30 
                   } 
               }, 
               series: [{ points: [
                       { x: 'Porcentaje de Recaudación', y: <?php echo $porcentaje; ?> }
                   ] }] 
           }) 
       ); 
       function defaultOptions() { 
           return { 
               debug: true, 
               type: 'gauge ', 
               animation_duration: 0, 
               legend_visible: false, 
               xAxis: { 
                   scale: { 
                       // Helps position the marker on top of the y Axis. 
                       range: [0, 1] 
                   } 
               }, 
               palette: { 
                   pointValue: '%yValue', 
                   ranges: [ 
                       { value: [0, 30], color: '#FF5353' }, 
                       { value: [30, 70], color: '#FFD221' }, 
                       { value: [70, 100], color: '#77E6B4' } 
                   ] 
               }, 
               yAxis: { 
                   defaultTick: { 
                       // Pads around the gauge 
                       label_visible: false
                   }, 
                   line: { 
                       width: 15, 
                       // Gaps occur at tick intervals defined below. 
                       breaks_gap: 0.03, 
                       color: 'smartPalette'
                   }, 
                   scale: { range: [0, 100], interval: 10 } 
               }, 
               defaultSeries: { 
                   opacity: 1, 
                   mouseTracking_enabled: false, 
                   shape: { 
                       label: { 
                           text: '%sum', 
                           align: 'center', 
                           verticalAlign: 'middle'
                       } 
                   } 
               }, 
               defaultPoint: { 
                   marker: { 
                       outline: { 
                           width: 8, 
                           color: 'currentColor'
                       }, 
                       fill: 'white', 
                       type: 'circle', 
                       size: 35 
                   } 
               }, 
               series: [ 
                   { 
                       type: 'marker', 
                       mouseTracking_enabled: false, 

                       points: [{ y: 58 }] 
                   } 
               ] 
           }; 
       }
   </script>
   <br>
   <br>

   <!-- Gráficas de barras -->
   <?php
   // Conectar a la base de datos
   include('../config/conexion.php');
   // Consulta para obtener datos
   $consulta = "SELECT fechas, total_cuentas_catastrales, recaudacion_millones_pesos FROM recaudacion";
   $resultado = $conexion->query($consulta);
   // Recopilar datos para Chart.js
   $fechas = [];
   $totalCuentas = [];
   $recaudacion = [];
   while ($fila = $resultado->fetch_assoc()) {
       $fechas[] = $fila['fechas'];
       $totalCuentas[] = $fila['total_cuentas_catastrales'];
       $recaudacion[] = $fila['recaudacion_millones_pesos'];
   }
   ?>
   <!-- Gráfica de barras: Total de CC's con pago -->
   <div class="bar1">
       <div class="chart-container"><center>
           <h1>Total de CC's con pago</h1></center>
           <canvas id="graficaCuentas" width="350" height="150"></canvas> 
           <button class="btn4" onclick="openModal('modal4')">Editar</button>
       </div>
   </div>

   <!-- Gráfica de barras: Recaudación en mdp -->
   <div class="bar2">    
       <div class="chart-container"> 
           <center><h1>Recaudación en mdp</h1></center>
           <canvas id="graficaRecaudacion" ></canvas>
           <button class="btn5" onclick="openModal('modal5')">Editar</button>
       </div>
   </div>

   <!-- Script para generar las gráficas de barras -->
   <script>
       // Datos para la gráfica de cuentas catastrales
       var datosCuentas = {
           labels: <?php echo json_encode($fechas); ?>,
           datasets: [{
               label: 'Total de Cuentas Catastrales',
               data: <?php echo json_encode($totalCuentas); ?>,
               backgroundColor: '#480101', // Ginda
               borderWidth: 1
           }]
       };
   
       // Datos para la gráfica de recaudación
       var datosRecaudacion = {
           labels: <?php echo json_encode($fechas); ?>,
           datasets: [{
               label: 'Recaudación en millones de pesos',
               data: <?php echo json_encode($recaudacion); ?>,
               backgroundColor: '#480101', // Ginda
               borderWidth: 1
           }]
       };

       // Generar gráficas de barras
       var graficaCuentas = new Chart(document.getElementById('graficaCuentas').getContext('2d'), {
           type: 'bar',
           data: datosCuentas,
           options: {
               responsive: true
           }
       });
   
       var graficaRecaudacion = new Chart(document.getElementById('graficaRecaudacion').getContext('2d'), {
           type: 'bar',
           data: datosRecaudacion,
           options: {
               responsive: true
           }
       });
   </script>
</div>

<!-- Modales -->
<div id="modal1" class="modal">
   <div class="modal-content">
       <span class="close" onclick="closeModal('modal1')">&times;</span>
       <h2>Editar Gráfico de Líneas</h2>
       <form method="post" action="">
        <label required class="valores"><input type="text" name="anio" placeholder="Año:"></label>
        <label class="valores"><input type="text" name="valor" placeholder="valor1"></label>
        <label required class="valores"><input type="text" name="anio2" placeholder="Año:"></label>
        <label class="valores"><input type="text" name="valor2" placeholder="valor2"></label>
        <button type="submit" name="guardar" class="guardar">Guardar</button>
        <br>
        <br>
    </form>
    <?php
    
    // Inicializar variables
    $anio = "";
    $valor = "";
    $anio2 = "";
    $valor2 = "";
    // Agregar un nuevo registro
    if (isset($_POST['guardar']) && !empty($_POST['anio']) && !empty($_POST['valor']) && !empty($_POST['anio2']) && !empty($_POST['valor2'])) {
      $anio = $_POST['anio'];
      $valor = $_POST['valor'];
      $anio2 = $_POST['anio2'];
      $valor2 = $_POST['valor2'];
      $sql = "INSERT INTO datos (anio, valor, anio2, valor2) VALUES ('$anio', '$valor', '$anio2', '$valor2')";
      if ($conexion->query($sql) === TRUE) {
          echo "Registro insertado correctamente";
      } else {
          echo "Error al insertar el registro: " . $conexion->error;
      }
  }
  
    
    // Eliminar un registro
    if (isset($_POST['eliminar'])) {
        $id = $_POST['eliminar_id'];
        $sql = "DELETE FROM datos WHERE id = $id";
        if ($conexion->query($sql) === TRUE) {
            echo "Registro eliminado correctamente";
        } else {
            echo "Error al eliminar el registro: " . $conexion->error;
        }
    }
    // Obtener todos los registros de la tabla
    $result = $conexion->query("SELECT * FROM datos");
    ?>
     <!-- Tabla de registros -->
     <table id="tablaCarreras">
        <thead>
            <tr>
                <th>ID</th>
                <th>Año1</th>
                <th>Dato</th>
                <th>Año2</th>
                <th>Dato2</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['anio']; ?></td>
                    <td><?php echo $row['valor']; ?></td>
                    <td><?php echo $row['anio2']; ?></td>
                    <td><?php echo $row['valor2']; ?></td>
                    <td>
    <div class="button-container">
        <a href="action/edit-graf-lineas.php?id=<?php echo $row['id']; ?>" class="edit">Editar</a></td>
        <td>
        <form method="post" action="">
            <input type="hidden" name="eliminar_id" value="<?php echo $row['id']; ?>">
            <button type="submit" name="eliminar" class="eliminar">Eliminar</button>
        </form>
    </div>
</td>

                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
   </div>
</div>

<div id="modal2" class="modal">
   <div class="modal-content">
       <span class="close" onclick="closeModal('modal2')">&times;</span>
       <p>Grafica de porsentaje de recaudación</p>
    <?php
  
    if (isset($_POST['eliminar'])) {
        $id = $_POST['eliminar_id'];
        $sql = "DELETE FROM porcentual WHERE id = $id";
        if ($conexion->query($sql) === TRUE) {
            echo "Registro eliminado correctamente";
        } else {
            echo "Error al eliminar el registro: " . $conexion->error;
        }
    }
    // Obtener todos los registros de la tabla
    $result = $conexion->query("SELECT * FROM porcentual");
    ?>
    <table id="tablaCarreras">
        <thead>
            <tr>
                <th>ID</th>
                <th>Concepto</th>
                <th>Porsentaje %</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['tipo']; ?></td>
                    <td><?php echo $row['valor']; ?></td>
                    <td>
    <div class="button-container">
        <a href="action/edit-circulo.php?id=<?php echo $row['id']; ?>" class="edit">Editar</a></td>
        <td>
        <form method="post" action="">
            <input type="hidden" name="eliminar_id" value="<?php echo $row['id']; ?>">
            <button type="submit" name="eliminar" class="eliminar">Eliminar</button>
        </form>
    </div>
</td>

                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>   
    </div>
</div>

<div id="modal4" class="modal">
   <div class="modal-content">
       <span class="close" onclick="closeModal('modal4')">&times;</span>
       <p>Total de CC's con pago</p>
    <form method="post" action="">
        <label required ><ion-icon name="calendar-sharp"></ion-icon><input type="text" name="marca" placeholder="Fecha:"></label>
        <label><ion-icon name="trending-up-sharp"></ion-icon><input type="text" name="modelo" placeholder="Total cuentas catastrales: "></label>
        <button type="submit" name="guardar" class="guardar">Guardar</button>
        <br>
        <br>
    </form>
    <?php
   
    $marca = "";
    $modelo = "";
    // Agregar un nuevo registro
    if (isset($_POST['guardar']) && !empty($_POST['marca']) && !empty($_POST['modelo'])) {
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $sql = "INSERT INTO recaudacion (fechas, total_cuentas_catastrales) VALUES ('$marca', '$modelo')";
        if ($conexion->query($sql) === TRUE) {
            echo "Registro insertado correctamente";
        } else {
            echo "Error al insertar el registro: " . $conexion->error;
        }
    }
    
    // Eliminar un registro
    if (isset($_POST['eliminar'])) {
        $id = $_POST['eliminar_id'];
        $sql = "DELETE FROM recaudacion WHERE id = $id";
        if ($conexion->query($sql) === TRUE) {
            echo "Registro eliminado correctamente";
        } else {
            echo "Error al eliminar el registro: " . $conexion->error;
        }
    }
    // Obtener todos los registros de la tabla
    $result = $conexion->query("SELECT * FROM recaudacion");
    ?>
    <!-- Tabla de registros -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha......</th>
                <th>Total cuentas catastrales</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['fechas']; ?></td>
                    <td><?php echo $row['total_cuentas_catastrales']; ?></td>
                    <td>
    <div class="button-container">
        <a href="edit.php?id=<?php echo $row['id']; ?>" class="edit">Editar</a></td>
        <td>
        <form method="post" action="">
            <input type="hidden" name="eliminar_id" value="<?php echo $row['id']; ?>">
            <button type="submit" name="eliminar" class="eliminar">Eliminar</button>
        </form>
    </div>
</td>

                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>   
    </div>
</div>

<div id="modal5" class="modal">
   <div class="modal-content">
       <span class="close" onclick="closeModal('modal5')">&times;</span>
       <form method="post" action="">
    </form>
    <?php
   
    // Inicializar variables
    $modelo = "";
    
    // Eliminar un registro
    if (isset($_POST['eliminar'])) {
        $id = $_POST['eliminar_id'];
        $sql = "DELETE FROM recaudacion WHERE id = $id";
        if ($conexion->query($sql) === TRUE) {
            echo "Registro eliminado correctamente";
        } else {
            echo "Error al eliminar el registro: " . $conexion->error;
        }
    }
    // Obtener todos los registros de la tabla
    $result = $conexion->query("SELECT * FROM recaudacion");
    ?>
    <!-- Tabla de registros -->
    <table>
        <thead>
       <center><p>Recaudación en mdp</p></center>
            <tr>
                <th>ID</th>
                <th>Fecha......</th>
                <th>Recaudación en mdp</th>
                <th>Editar</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['fechas']; ?></td>
                    <td><?php echo $row['recaudacion_millones_pesos']; ?></td>
                    <td>
<div class="nuevo">
                        <a href="editrmdp.php?id=<?php echo $row['id']; ?>">+</a></div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>

<!-- Funciones JavaScript para abrir y cerrar modales -->
<script>
   function openModal(modalId) {
       var modal = document.getElementById(modalId);
       modal.style.display = "block";
   }

   function closeModal(modalId) {
       var modal = document.getElementById(modalId);
       modal.style.display = "none";
   }

   // Cierra el modal si el usuario hace clic fuera del contenido del modal
   window.onclick = function(event) {
       var modals = document.getElementsByClassName("modal");
       for (var i = 0; i < modals.length; i++) {
           var modal = modals[i];
           if (event.target == modal) {
               modal.style.display = "none";
           }
       }
   }
</script>
</body>
</html>
