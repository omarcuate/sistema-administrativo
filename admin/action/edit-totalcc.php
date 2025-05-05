<?php
// Conecta a la base de datos
$conexion = new mysqli('localhost', 'root', '', 'sistemv_1');

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verifica si 'id' está set en los parámetros de la URL
if(isset($_GET['id'])) {
    $ID = $_GET['id'];

    // Procede con la obtención de datos solo si 'id' está set
    $sql = "SELECT * FROM recaudacion WHERE id='$ID'";
    $mostrar = mysqli_query($conexion, $sql);

    $filas = mysqli_fetch_assoc($mostrar);
    // Verifica si la obtención fue exitosa
    if ($filas) {
        $marca = $filas["fechas"];
        $modelo = $filas["total_cuentas_catastrales"];
    } else {
        // Maneja el caso donde no se encuentran datos para el ID proporcionado
        echo "No se encontraron datos para el ID proporcionado.";
        exit; // Detiene la ejecución adicional
    }
} 
    

else {
    // Maneja el caso donde 'id' no está set en los parámetros de la URL
    echo "No se proporcionó un ID válido.";
    
    
exit; // Detiene la ejecución adicional
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="../../css/style_adm.css">
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        
<script src="https://code.jscharting.com/latest/jscharting.js"></script>
        <script type="text/javascript" src="https://code.jscharting.com/latest/modules/types.js"></script>
        <script type="text/javascript" src="https://code.jscharting.com/latest/modules/types.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
       
</head>
<body>

<div class="user-info">
    <button onclick="location.href='../login/login/salir.php';" class="logout-button">Salir</button>
    <span>ADS</span>
</div>

<nav>
    <ul>
       <center> <li><strong>Dashboard</strong></li></center>
       <br>
        <li><ion-icon name="speedometer"></ion-icon>      <a href="index.php">Inicio</a></li>
        <li><ion-icon name="pie-chart"></ion-icon>        <a href="graficas.php">Graficas</a></li>
        <li><ion-icon name="file-tray-stacked"></ion-icon><a href="tablas.php">Tablas CRUDS</a></li>
        <li><ion-icon name="person-add"></ion-icon>       <a href="registro.php">Usuarios</a></li>
    </ul>
</nav>

<div class="content-box">
  <center> <h1><ion-icon name="create-sharp"></ion-icon>Editar</h1></center> 

  <div class="cont-edit">
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
       <label><ion-icon name="calendar-number-outline"></ion-icon>Fecha:</label><br>
       <input type="text" name="marca"
       value="<?php echo $marca;?>"><br>
 
       <label ><ion-icon name="pulse-sharp"></ion-icon>Total de cuentas catrastales:</label>
       <br>
       <input type="text" name="modelo"
       value="<?php echo $modelo;?>"><br>
 
       <input  class="cuadro" type="hidden" name="id" 
       value="<?php echo $ID;?>"><br>
 <button class="actualizar"type="submit" name="enviar">Actualizar</button>
       <a href="graficas.php" class="regresar">Regresar</a>
    </form>
   
    </div>
    <?php
                       
                       // Conecta a la base de datos
                      include('conexion.php');
                   
                       // Consulta para obtener datos
                       $consulta = "SELECT fechas, total_cuentas_catastrales, recaudacion_millones_pesos FROM recaudacion";
                       $resultado = $conexion->query($consulta);
                   
                       // Recopila datos para Chart.js
                       $fechas = [];
                       $totalCuentas = [];
                       $recaudacion = [];
                   
                       while ($fila = $resultado->fetch_assoc()) {
                           $fechas[] = $fila['fechas'];
                           $totalCuentas[] = $fila['total_cuentas_catastrales'];
                           $recaudacion[] = $fila['recaudacion_millones_pesos'];
                       }
                       ?>
                   
                   <div class="bar1">
                   <div class="chart-container"><center>
                       <h1>Total de CC's con pago</h1></center>
                           <canvas id="graficaCuentas" width="350" height="150"></canvas> 
                         </div>
                   </div>
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
                            // Configuración de las gráficas
                            var opciones = {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            };
                    
                            // Crear las gráficas
                            var ctxCuentas = document.getElementById('graficaCuentas').getContext('2d');
                            var graficaCuentas = new Chart(ctxCuentas, {
                                type: 'bar',
                                data: datosCuentas,
                                options: opciones
                            });
                            </script>

</div>

</body>
</html>




<style>
.cont-edit{
    width: 40%;
    height: auto;
}
.regresar{
    background-color: #FFC300;
    border: none;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    margin: 10px;
    position: relative;
    color: #fff;
    text-decoration: none;
    
    }

 .regresar:hover{
    background-color:#EEA600 ;
}
input{ 
    width: 80%;
    background-color: #fff;
    padding: 10px;
    border-radius: 10px;
    margin: 3% auto;
    border: solid 1px;
   margin-left: 7%;
}
label{
    text-decoration: none;
    font-size: 20px;
    font-family: 'Times New Roman', Times, serif;
    margin-left: 7%;
}
.actualizar {
    background-color: dodgerblue;
    border: none;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    margin: 10px;
    position: relative;
    color: black;
    margin-left: 27%;

}
.actualizar:hover{
    background-color: blue;
    color: #fff;
}
.bar1{
width: 500px;
height: 300px;
border-radius: 10px;
box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
border: none;
margin: 50px;
margin-top: -300px;
margin-left: 50%;
}
</style>