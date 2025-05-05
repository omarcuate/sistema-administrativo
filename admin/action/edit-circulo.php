<?php
include('conexion.php');
 
if(isset($_POST['enviar'])){
    //aqui entra cuando sepreciona el boton enviar
$ID=$_POST['id'];
$valor=$_POST['valor'];
$modelo=$_POST['tipo'];
 
 
$sql="update porcentual set valor='".$valor."' where id='".$ID."'";

 
 
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
    $sql="select * from porcentual where id='".$ID."'";
    $mostrar=mysqli_query($conexion,$sql);
 
    $filas=mysqli_fetch_assoc($mostrar);
    $valor=$filas["valor"];
}
 
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ediatr</title>
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
    <button onclick="location.href='../../config/salir.php';" class="logout-button">Salir</button>
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

<div class="content-box">
  <center> <h1><ion-icon name="create-sharp"></ion-icon>Editar</h1></center> <br>

  <div class="cont-edit">
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
       <label><ion-icon name="stats-chart-outline"></ion-icon>Porcentaje de recaudación</label><br>

       <input type="text" name="valor" value="<?php echo $valor;?>"><br>

 
       <input  class="cuadro" type="hidden" name="id" 
       value="<?php echo $ID;?>"><br>
 <button class="actualizar"type="submit" name="enviar">Actualizar</button>
       <a href="../graficas.php" class="regresar">Regresar</a>
    </form>
   
    </div>
   
<div class="porcentual"> 
<canvas id="myChart" class="circulo"></canvas>

<?php
    // Conéctate a la base de datos de nueva cuenta para evitar problemas 
  include('conexion.php');

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

    <script>

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                data: <?php echo json_encode($data); ?>,
                backgroundColor: [
                    '#950000',
                    '#480101d7'
                ],
              
              
                borderWidth: 1
            }]
        }
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

.porcentual {
  height: 30%;
  width: 30%; /* Anchura del 25% del contenedor padre */
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.747);
  border-radius: 10px;
  margin-top: -20%;
  margin-left: 60%;
  
}


</style>