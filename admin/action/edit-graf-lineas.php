<?php
include('../../config/conexion.php');
 
if(isset($_POST['enviar'])){
    //aqui entra cuando sepreciona el boton enviar
$ID=$_POST['id'];
$anio=$_POST['anio'];
$valor=$_POST['valor'];
$anio2=$_POST['anio2'];
$valor2=$_POST['valor2'];
 
 
$sql="update datos set anio='".$anio."',anio2='".$anio2."',valor='".$valor."',
valor2='".$valor2."' where id='".$ID."'";
 
 
$result=mysqli_query($conexion,$sql,);
 
if($result){
    echo "<script language='javaScript'>
    alert('los datos se an actualizado');
    location.assign('../graficas.php');
    </script>";
}else{
    echo "<script language='javaScript'>
    alert('los datos NO se an actualizado');
    location.assign('../graficas.php');
    </script>";
 
}
 
}else{
    //aqui entra si no se presiona el btn enviar
    $ID=$_GET['id'];
    $sql="select * from datos where id='".$ID."'";
    $mostrar=mysqli_query($conexion,$sql);
 
    $filas=mysqli_fetch_assoc($mostrar);
    $anio=$filas["anio"];
    $valor=$filas["valor"];
    $anio2=$filas["anio2"];
    $valor2=$filas["valor2"];
 
 
}
 
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar</title>
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
        <li><ion-icon name="speedometer"></ion-icon>      <a href="../index.php">Inicio</a></li>
        <li><ion-icon name="pie-chart"></ion-icon>        <a href="../graficas.php">Graficas</a></li>
        <li><ion-icon name="file-tray-stacked"></ion-icon><a href="../tablas.php">Tablas CRUDS</a></li>
        <li><ion-icon name="person-add"></ion-icon>       <a href="../usuarios.php">Usuarios</a></li>
    </ul>
</nav>
<center> <h1><ion-icon name="create-sharp"></ion-icon>Editar</h1></center> 
 <div class="content-box">
  

  <div class="cont-edit">
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
      <div class="form-row">
        <div class="input-wrapper">
          <label><ion-icon name="calendar-number-outline"></ion-icon>Fecha:</label>
          <input type="text" name="anio" value="<?php echo $anio;?>">
        </div>
        <div class="input-wrapper">
          <label><ion-icon name="calendar-number"></ion-icon>Fecha2:</label>
          <input type="text" name="anio2"value="<?php echo $anio2;?>">
        </div>
      </div>
      <div class="form-row">
        <div class="input-wrapper">
          <label><ion-icon name="analytics"></ion-icon>Dato:</label>
          <input type="text" name="valor" value="<?php echo $valor;?>">
        </div>
        <div class="input-wrapper">
          <label><ion-icon name="resize-outline"></ion-icon>Dato2:</label>
          <input type="text" name="valor2" value="<?php echo $valor2;?>">
        </div>
      </div>
      <input class="cuadro" type="hidden" name="id" value="<?php echo $ID;?>">
      <button class="actualizar" type="submit" name="enviar">Actualizar</button>
      <a href="../graficas.php" class="regresar">Regresar</a>
    </form>
  </div>
   
  <?php
   include('../../config/conexion.php');
   $conexion = mysqli_query($conexion, "SELECT * FROM datos");
if (!$conexion) {
    die('Error al ejecutar la consulta: ' . mysqli_error($link));
}
?>

<figure class="highcharts-figure">
    <div id="container" ></div>
</figure>

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
</script>


</div>

   

</div>

</body>
</html>




<style>
.cont-edit{
    width: 40%;
    height: auto;
}
h1{
  text-align: center;
  position: relative;
  margin-top: -50px;
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
.form-row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
}

.input-wrapper {
  flex: 1;
  margin-right: 10px;
}

.input-wrapper label {
  display: block;
  margin-bottom: px;
}

.input-wrapper input {
    width: 80%;
    background-color: #fff;
    padding: 10px;
    border-radius: 10px;
    margin: 3% auto;
    border: solid 1px;
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
    color: #fff;
    margin-left: 27%;

}
.actualizar:hover{
    background-color: blue;
}
.bar2{
width: 500px;
height: 300px;
border-radius: 10px;
box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
border: none;
margin: 50px;
margin-top: -300px;
margin-left: 50%;
}
.content-box {
    display: flex;
}

.highchart-container {
    flex: 1;
     
}
.highcharts-figure{
  max-width: 550px;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.747);
}

.cont-edit {
    flex: 1; 
    margin: 5%;
}
</style>