<?php
session_start();

if (isset($_SESSION['email'])) {
    header("location: ../login/index.php");
}

?>
<?php

session_start();

include('conexion.php');

$correo = $_POST['email'];
$contrasena = $_POST['contrasena'];

// Validate and hash password
$contrasena = hash('sha512', $contrasena);

// Perform database query
$validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE email = '$correo' AND contrasena = '$contrasena'");

if (mysqli_num_rows($validar_login) > 0) {
    $user_data = mysqli_fetch_assoc($validar_login);
    $_SESSION['email'] = $correo;

    // Check user type
    if ($user_data['tipo_usuario'] == 'Comun') {
        header("Location: ../pages/index.php");
    } elseif ($user_data['tipo_usuario'] == 'Admin') {
        header("Location: ../admin/index.php");
    } else {
        // Handle unknown user type
        echo 'Unknown user type';
        exit;
    }
} else {
    echo '
    <script> 
        alert("El usuario no existe por favor verifique los datos");
        window.location = "../index.html";
    </script>';
    exit;
}
?>