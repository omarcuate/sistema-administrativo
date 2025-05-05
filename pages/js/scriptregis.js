const inputTermino = document.getElementById('termino');
const autocompleteResults = document.getElementById('autocomplete-results');

inputTermino.addEventListener('input', function () {
    const inputValue = inputTermino.value.toLowerCase();

    // Realizar una solicitud AJAX para obtener datos de autocompletado desde el servidor
    const xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            const filteredResults = data.filter(item => item.toLowerCase().includes(inputValue));
            displayResults(filteredResults);
        }
    };

    xhr.open('GET', 'autocompletaregis.php?termino=' + inputValue, true);
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
        resultItem.textContent = result;

        resultItem.addEventListener('click', function () {
            inputTermino.value = result;
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