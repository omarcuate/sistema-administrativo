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
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/style_cm.css" />
    <link rel="stylesheet" href="../css/tablas.css">
    <title>Tablas</title>
    <link rel="icon" type="img" href="../media/colibri.svg" />
  </head>
  <body>
    <header>
      <div>
        <nav class="navegacion">
          <ul class="menu">
            <li><a href="index.php">Inicio</a></li>
            <li>
              <a>Graficos</a>
              <ul class="submenu">
                <li><a> Tablas</a></li>
                <li><a> Graficas</a></li>
              </ul>
            </li>
            <li>
              <a>Funciones</a>
              <ul class="submenu">
                <li><a> Calculas Claves</a></li>
                <li><a> Convertidor SQL</a></li>
                <li><a> Limpieza de datos</a></li>
              </ul>
            </li>
          </ul>
        </nav>
      </div>

      <nav class="navegacion">
        <div>
          <ul class="menu2">
            <li><a href="..\login/login/salir.php"> Cerrar sesión</a></li>
          </ul>
        </div>
      </nav>
    </header>

    <!-- Zona, ahi adentro colocas tu contenido -->

    <section class="zona1 box box4 shadow4">
      <div class="icon-container">
        <div><img class="icon1" src="../media/inicio/cruds.png" /></div>
        <div><img class="icon1" src="../media/inicio/busqueda.png" /></div>
      </div>
      <br />
    <div >
        <form action="action/buscar-data.php" method="post">
            <label for="termino"></label>
            <input type="text" id="termino" name="termino" required placeholder="Buscar">
            <button type="submit">Buscar</button>
        </form>

        <!-- Contenedor para mostrar resultados de autocompletado -->
        <div id="autocomplete-results"></div>
    </div>
      <br />
      <center><p>
        <strong>IMPORTANTE:</strong>Escribir el nombre del municipio</p></center>

      <br /><br />
      <div>
      </div>
    </section>

    <!-- script del header -->
    <script type="text/javascript">
      window.addEventListener("scroll", function () {
        var header = document.querySelector("header");
        header.classList.toggle("abajo", window.scrollY > 0);
      });
    </script>
     <script src="js/script.js">  </script>
  </body>
</html>
































<style>
        #autocomplete-results {
          position: absolute;
            width: 25%;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: none;
         margin-left: 15%;
        }

        #autocomplete-results li {
            list-style: none;
            padding: 8px;
            cursor: pointer;
        }

        #autocomplete-results li:hover {
            background-color: #f5f5f5;
        }
    </style>