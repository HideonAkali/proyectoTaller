const autorSelect = document.getElementById("tipoAutor");
const libroSelect = document.getElementById("tipoLibro");
const messageDiv = document.getElementById("resultado");

fetch("json/autores.json")
    .then(response => response.json())
    .then(data => {
        data.autores.forEach(autor => {
            const option = document.createElement("option");
            option.textContent = autor.nombre;
            autorSelect.appendChild(option);
        });

        autorSelect.addEventListener("change", function () {
            const autorSeleccionado = this.value;
            const librosAutor = data.autores.find(autor => autor.nombre === autorSeleccionado).libros;

            libroSelect.innerHTML = "<option selected>Seleccione un libro</option>";
            librosAutor.forEach(libro => {
                const option = document.createElement("option");
                option.textContent = libro.titulo;
                libroSelect.appendChild(option);
            });
        });
    })
    .catch(error => {
        console.error("Error al cargar el JSON:", error);
        messageDiv.textContent = "Error al cargar los datos. Por favor, intenta nuevamente más tarde.";
    });