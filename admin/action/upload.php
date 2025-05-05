<?php
require_once "../../config/con_carga.php"; 

// Verificamos si se ha enviado un archivo
if(isset($_FILES['sqlFile'])) {
    $file_name = $_FILES['sqlFile']['name'];
    $file_tmp = $_FILES['sqlFile']['tmp_name'];
    $table_name = $_POST['tableName']; // Nombre de la tabla
    // Directorio donde se almacenarán los archivos SQL
    $upload_directory = 'uploads/';

    // Verificamos si el directorio de carga existe, si no, lo creamos
    if (!file_exists($upload_directory)) {
        mkdir($upload_directory, 0777, true); // Creamos el directorio con permisos adecuados
    }

    // Movemos el archivo al directorio especificado
    if (move_uploaded_file($file_tmp, $upload_directory.$file_name)) {
        // Luego, puedes procesar el archivo SQL para insertar los datos en la base de datos
        // Aquí solo un ejemplo de cómo podrías hacerlo utilizando MySQLi
        $conexion = conectarBaseDatos(); // Llamamos a la función para conectar a la base de datos

        // Cargamos el contenido del archivo SQL
        $sql_content = file_get_contents($upload_directory.$file_name);

        // Ejecutamos el contenido del archivo SQL
        if ($conexion->multi_query($sql_content) === TRUE) {
            echo "Archivo SQL cargado y ejecutado correctamente.";
        } else {
            echo "Error al cargar y ejecutar el archivo SQL: " . $conexion->error;
        }

        // Cerramos la conexión
        $conexion->close();
    } else {
        echo "Error al mover el archivo al directorio de carga.";
    }
} else {
    echo "No se ha seleccionado ningún archivo.";
}
?>
