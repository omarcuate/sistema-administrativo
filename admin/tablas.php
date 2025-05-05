<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tablas</title>
<link rel="stylesheet" href="../css/style_adm.css">
<link rel="stylesheet" href="../css/tablas-adm.css">
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>
<div class="user-info">
    <button onclick="location.href='../config/salir.php';" class="logout-button">Salir</button>
    <span>ADS</span>
</div>

<nav>
    <ul>
       <center> <li><strong>Dashboard</strong></li></center>
       <br>
        <li><ion-icon name="speedometer"></ion-icon>      <a href="index.php">Inicio</a></li>
        <li><ion-icon name="pie-chart"></ion-icon>        <a href="graficas.php">Graficas</a></li>
        <li><ion-icon name="file-tray-stacked"></ion-icon><a href="tablas.php">Tablas CRUDS</a></li>
        <li><ion-icon name="person-add"></ion-icon>       <a href="usuarios.php">Usuarios</a></li>
        <li><ion-icon name="aperture"></ion-icon>         <a href="../pages/index.php">Web site</a></li>
        <li><ion-icon name="terminal"></ion-icon>             <a href="consola.php">Consola</a></li>
    </ul>
</nav>

<div class="content-box">
<body>

<a class="dashboard-button analytics-button"  onclick="openModal('modal4')">
  <i><ion-icon name="file-tray-full"></ion-icon></i>
  <div class="button-title">Cargar tabla</div>
</a> <!-- Botón para analytics -->

<a class="dashboard-button calendar-button" href="http://localhost/phpmyadmin/">
  <i><ion-icon name="server"></ion-icon></i><br>
  <div class="button-title">MYSQL admin</div>
</a> <!-- Botón para calendar -->


<a class="dashboard-button messages-button" href="action/editdata.php">
<i><ion-icon name="brush"></ion-icon></i>
<div class="button-title">Editar datos</div>
</a>



<!-- Include Font Awesome CSS (necesitarás conexión a internet para esto) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</body>
    </div>
<!-- modal para crgar un a tabla squl -->
    <div id="modal4" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal('modal4')">&times;</span>

    <form id="sqlForm" enctype="multipart/form-data">

    <center><ion-icon name="cloud-upload" class="nuve"></ion-icon><h1>Cargar una tabla</h1></center>

    <label for="sqlFile" class="custom-file-upload">
Carge el archivo (.SQL)
    </label></label>
    <input type="file" name="sqlFile" id="sqlFile" onchange="showFileName()">
    <p id="fileName"></p>
    <label>Nombre de la tabla:</label><br>
    <select type="text" name="tableName" id="tableName">
                    <option value="dbf05">dbf05</option>
                    <option value="ddbf0">dbf03</option>
                    <option value="prueva">prueva</option>
                </select>
   
    <button type="button" onclick="uploadSQLFile()" class="subir">
                Subir Archivo
    </button>
</form>
<div id="response"></div>
    <script>
        function showFileName() {
    const input = document.getElementById('sqlFile');
    const fileName = document.getElementById('fileName');

    // Verificar si se seleccionó un archivo
    if (input.files.length > 0) {
        fileName.textContent = input.files[0].name;
    } else {
        fileName.textContent = ''; // Borrar el texto si no hay archivo seleccionado
    }
}

        function uploadSQLFile() {
            var form = document.getElementById("sqlForm");
            var formData = new FormData(form);

            fetch("action/upload.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById("response").innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>

    </div>
</div>

</body>
</html>


<script>
  function openModal(id) {
  document.getElementById(id).style.display = "block";
}
function closeModal(id) {
  document.getElementById(id).style.display = "none";
}
</script>