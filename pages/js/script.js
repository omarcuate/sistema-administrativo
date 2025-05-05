const inputTermino = document.getElementById('termino');
const autocompleteResults = document.getElementById('autocomplete-results');

inputTermino.addEventListener('input', function () {
    const inputValue = inputTermino.value.toLowerCase();

    // Realizar una solicitud AJAX para obtener datos de autocompletado desde el servidor
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                console.log('Respuesta del servidor:', data);
                displayResults(data);
            } else {
                console.error('Error en la solicitud AJAX:', xhr.status, xhr.statusText);
            }
        }
    };

    xhr.open('GET', 'autocompletar.php?termino=' + inputValue, true);
    xhr.send();
});

function displayResults(results) {
    autocompleteResults.innerHTML = '';

    if (results.length === 0) {
        autocompleteResults.style.display = 'none';
        return;
    }

    results.forEach(result => {
        const resultItem = document.createElement('li');

        // Mostrar ID y Nombre del municipio
        resultItem.textContent = `${result.id_municipio}:${result.municipio}`;

        resultItem.addEventListener('click', function () {
            // Mostrar el ID en el campo de búsqueda al seleccionar
            inputTermino.value = result.id_municipio;
            autocompleteResults.style.display = 'none';
        });

        autocompleteResults.appendChild(resultItem);
    });

    autocompleteResults.style.display = 'block';
}

// Cierra el autocompletado si se hace clic fuera de él
document.addEventListener('click', function (event) {
    if (!inputTermino.contains(event.target) && !autocompleteResults.contains(event.target)) {
        autocompleteResults.style.display = 'none';
    }
});