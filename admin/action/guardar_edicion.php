<?php
if(isset($_POST['clv_catastral'], $_POST['municipio'], $_POST['zona'], $_POST['manzana'], $_POST['lote'], $_POST['nomprop'], $_POST['rfc'], $_POST['domfis'], $_POST['curp'])) {

    $clv_catastral = $_POST['clv_catastral'];
    $municipio = $_POST['municipio'];
    $zona = $_POST['zona'];
    $manzana = $_POST['manzana'];  
    $lote = $_POST['lote']; 
    $nomprop = $_POST['nomprop']; 
    $rfc = $_POST['rfc']; 
    $domfis = $_POST['domfis']; 
    $curp = $_POST['curp'];
    

    $conexion = new mysqli('localhost', 'root', '', 'sistemv_1');
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    
    $sql = "UPDATE dbft05 SET municipio = '$municipio', zona = '$zona', manzana = '$manzana', lote = '$lote', nomprop = '$nomprop', rfc = '$rfc', domfis = '$domfis', curp = '$curp' WHERE clv_catastral = '$clv_catastral'";
    
    
    if ($conexion->query($sql) === TRUE) {
        echo "<script>alert('Los cambios se guardaron correctamente.');</script>";
    } else {
        echo "Error al guardar los cambios: " . $conexion->error;
    }
    
    $conexion->close();
} else {
    echo "No se recibieron datos del formulario.";
}
?>
