<?php
    $servidor = "localhost";
    $usuario = "root";
    $password = "";
    $db = "sistemv_1";
    $conexion = new mysqli($servidor, $usuario, $password, $db);

    if($conexion->connect_error){
        die("Conexión fallida: " . $conexion->connect_error);
    }
?>