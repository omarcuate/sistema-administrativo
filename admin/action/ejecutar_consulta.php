<?php
$servidor = "localhost";
$usuario = "root";
$password = "";
$db = "sistemv_1";
$conexion = new mysqli($servidor, $usuario, $password, $db);

if($conexion->connect_error){
    die("Conexión fallida: " . $conexion->connect_error);
}

// Recibir la consulta SQL del formulario
$consulta = $_POST['consulta'];

// Ejecutar la consulta
$resultado = $conexion->query($consulta);

// Mostrar resultados o manejar errores según sea necesario
if ($resultado) {
    // Mostrar los resultados de la consulta
    while ($fila = $resultado->fetch_assoc()) {
        // Procesar cada fila de resultados
        echo "<pre>";
        print_r($fila);
        echo "</pre>";
    }
} else {
    // Manejar errores
    echo "Error en la consulta: " . $conexion->error;
}

// Cerrar la conexión
$conexion->close();
?>



//<?php
// Establecer la conexión a la base de datos
//$conexion = new mysqli("localhost", "root", "", "test");

// Verificar la conexión
//if ($conexion->connect_error) {
   // die("Error de conexión: " . $conexion->connect_error);
//}

// Recibir la consulta SQL del formulario
//$consulta = $_POST['consulta'];

// Ejecutar la consulta
//$resultado = $conexion->query($consulta);

// Crear un nuevo objeto PHPExcel
//require_once 'PHPExcel.php';
//$objPHPExcel = new PHPExcel();

// Establecer el título de la hoja de cálculo
//$objPHPExcel->getActiveSheet()->setTitle('Resultados');

// Agregar los encabezados de las columnas
//$columnas = array_keys($resultado->fetch_assoc());
//$objPHPExcel->getActiveSheet()->fromArray($columnas, NULL, 'A1');

// Inicializar el contador de filas
//$contador_filas = 2;

// Agregar los datos de la consulta
//while ($fila = $resultado->fetch_assoc()) {
    //$objPHPExcel->getActiveSheet()->fromArray($fila, NULL, 'A' . $contador_filas);
    //$contador_filas++;
//}

// Crear un objeto Writer para Excel
//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

// Definir el nombre del archivo
//$filename = 'resultados.xlsx';

// Configurar las cabeceras para la descarga del archivo
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header('Content-Disposition: attachment;filename="' . $filename . '"');
//header('Cache-Control: max-age=0');

// Descargar el archivo
//$objWriter->save('php://output');

// Cerrar la conexión
//$conexion->close();
//?>

