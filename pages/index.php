<?php
session_start();

if (!isset($_SESSION['email'])) {
    echo '
        <script>
            alert("por favos inicie sesión")
            window. location = "../login/index.php";
        </script>

        ';
    session_destroy();
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style_cm.css">
    <title>Davel</title>
    <link rel="icon" type="img" href="../media//colibri.svg">
    
</head>



<body>
    <header>

  
        <div>
            <nav class="navegacion">
                <ul class="menu">
                    <li><a href="index.php">Inicio</a></li>
                    <li><a>Graficos</a>
                        <ul class="submenu">
                            <li><a href="tablas.php"> Tablas</a></li>
                            <li><a href="men_graficas/graf.php"> Graficas</a></li>
                        </ul>
                    </li>
                    <li><a>Funciones</a>
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
                    <li><a href="../config/salir.php"> Cerrar sesión</a></li>
                </ul>
            </div>
        </nav>
        
    </header>

    <!-- Zona, ahi adentro colocas tu contenido -->

    <section class="zona1 box box4 shadow4">
        <div> <img class="logoin" src="../media/logo.svg"> </div>
        <!-- menu con imagenes-->
        <div class="botons">

            <div class="contenedor1" >
                <a href="tablas.php"><img src="../media/inicio/crud.png" class="icon"></a>
                <h2 class="texto">Tablas</h2>
            </div>

            <div class="contenedor1" id="uno">
                <a href="men_graficas/graf.php"><img src="../media/inicio/calculo.png" class="icon"></a>
                <h2 class="texto">Graficas</h2>
            </div>

            <div class="contenedor1" id="uno">
                <a href="http://127.0.0.1:5000/sqls"><img src="../media/inicio/sql.png" class="icon"></a>
                <h2 class="texto">Convertidor SQL</h2>
            </div>

            <div class="contenedor1" id="uno">
                <a href="http://127.0.0.1:5000"><img src="../media/inicio/claves.png" class="icon"></a>
                <h2 class="texto">Claves Catastrales</h2>

            </div>

            <div class="contenedor1" id="uno">
                <a href="http://127.0.0.1:5000/limpieza"><img src="../media/inicio/limpieza-datos.png" class="icon"></a>
                <h2 class="texto">Limpieza De Datos</h2>

            </div>
        </div>

    </section>
    
    <!-- fin de la zona -->


    <!-- script del header -->
    <script src="asest/index.js"></script>
    <script type="text/javascript">
        window.addEventListener("scroll", function() {
            var header = document.querySelector("header");
            header.classList.toggle("abajo", window.scrollY > 0);
        })
    </script>
</body>

</html>
