<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit-Data</title>
<link rel="stylesheet" href="../../css/edit_data.css">
<link rel="stylesheet" href="../../css/style_adm.css">
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>
<body>



<nav>
    <ul>
       <center> <li><strong>Dashboard</strong></li></center>
       <br>
        <li><ion-icon name="speedometer"></ion-icon>      <a href="../index.php">Inicio</a></li>
        <li><ion-icon name="pie-chart"></ion-icon>        <a href="../graficas.php">Graficas</a></li>
        <li><ion-icon name="file-tray-stacked"></ion-icon><a href="../tablas.php">Tablas CRUDS</a></li>
        <li><ion-icon name="person-add"></ion-icon>       <a href="../registro.php">Usuarios</a></li>
        <li><ion-icon name="aperture"></ion-icon>         <a href="../../pages/index.php">Web site</a></li>
    </ul>
</nav>

<div class="content-box">
 <center> <h1>Editar Registros</h1></center> 
   
<div class="container">

  <div class="controls">
    <label for="dataAmount">Mostrar:</label>
    <select id="dataAmount" onchange="updateTable()">
      <option value="5">5 datos</option>
      <option value="50">50 datos</option>
      <option value="100">100 datos</option>
      <option value="all">Todos los datos</option>
    </select>
  </div>
  <table id="dataTable">
    <!-- Aquí se generará la tabla dinámicamente -->
  </table>
</div>

</div>

<script>
  function updateTable() {
    var amount = document.getElementById("dataAmount").value;
    var url = "mos_tabla.php?amount=" + amount;
    
    fetch(url)
      .then(response => response.text())
      .then(data => {
        document.getElementById("dataTable").innerHTML = data;
        addEditDeleteButtons(); // Llama a la función para agregar botones de editar y eliminar
      });
  }
  
  // Función para agregar botones de editar y eliminar a cada fila de la tabla
  function addEditDeleteButtons() {
    var tableRows = document.querySelectorAll("#dataTable tr");
    tableRows.forEach(row => {
      var id = row.cells[0].textContent; // Suponiendo que el ID está en la primera celda
      row.innerHTML += "<td><a href='edit-data.php?id=" + id + "'class='edit'>Editar</a></td>";
      row.innerHTML += "<td><a href='eliminar-data.php?id=" + id + "' class='eliminar' onclick='return confirm(\"¿Estás seguro de que quieres eliminar este registro?\")'>Eliminar</a></td>";
    });
  }
  // Llamamos a la función para cargar la tabla con el valor inicial seleccionado
  updateTable();
</script>
</body>
</html>
