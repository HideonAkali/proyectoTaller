// Función para filtrar la tabla de autores
function filtrarTabla() {
    var inputNombre = document.getElementById("nombreFilter").value.toUpperCase();
    var inputApellido = document.getElementById("apellidoFilter").value.toUpperCase();
    var inputNacionalidad = document.getElementById("nacionalidadFilter").value.toUpperCase();
    var tabla = document.getElementById("tablaAutores");
    var filas = tabla.getElementsByTagName("tr");

    // Recorrer todas las filas y ocultar las que no cumplen con los filtros
    for (var i = 0; i < filas.length; i++) {
        var celdas = filas[i].getElementsByTagName("td");
        var mostrarFila = true;

        // Comparar cada celda con los filtros
        if (celdas.length > 0) {
            var nombre = celdas[1].textContent.toUpperCase();
            var apellido = celdas[2].textContent.toUpperCase();
            var nacionalidad = celdas[3].textContent.toUpperCase();

            if (inputNombre && nombre.indexOf(inputNombre) === -1) {
                mostrarFila = false;
            }
            if (inputApellido && apellido.indexOf(inputApellido) === -1) {
                mostrarFila = false;
            }
            if (inputNacionalidad && nacionalidad.indexOf(inputNacionalidad) === -1) {
                mostrarFila = false;
            }
        }

        // Mostrar u ocultar la fila según los resultados del filtro
        if (mostrarFila) {
            filas[i].style.display = "";
        } else {
            filas[i].style.display = "none";
        }
    }
}

// Eventos para detectar cambios en los campos de filtro y aplicar el filtro
document.getElementById("nombreFilter").addEventListener("input", filtrarTabla);
document.getElementById("apellidoFilter").addEventListener("input", filtrarTabla);
document.getElementById("nacionalidadFilter").addEventListener("input", filtrarTabla);

// Función para cargar detalles de un autor seleccionado
function cargarDetallesAutor(autorID) {
    if (autorID) {
        $.ajax({
            url: 'modificar.php',
            type: 'GET',
            data: {
                id: autorID
            },
            success: function (response) {
                var autor = JSON.parse(response);
                document.getElementById('autorID').value = autor.id;
                document.getElementById('nombreAutor').value = autor.nombre;
                document.getElementById('apellidoAutor').value = autor.apellido;
                document.getElementById('nacionalidadAutor').value = autor.nacionalidad;
            },
            error: function (xhr, status, error) {
                console.error("Error al cargar los detalles del autor:", error);
            }
        });
    }
}

// Script para el formulario de modificación de autores
document.getElementById('formModificarAutor').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevenir la sumisión del formulario por defecto

    var nombreAutor = document.getElementById('nombreAutor').value;
    var apellidoAutor = document.getElementById('apellidoAutor').value;
    var nacionalidadAutor = document.getElementById('nacionalidadAutor').value;

    Swal.fire({
        title: "¿Estás seguro?",
        html: `Vas a modificar los datos del autor a:<br><br>
                  <strong>Nombre:</strong> ${nombreAutor}<br>
                  <strong>Apellido:</strong> ${apellidoAutor}<br>
                  <strong>Nacionalidad:</strong> ${nacionalidadAutor}<br><br>
                  ¿Deseas continuar?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, modificar!"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "¡Modificado!",
                text: "Los datos del autor han sido modificados.",
                icon: "success"
            }).then(() => {
                // Continuar con la sumisión del formulario
                event.target.submit();
            });
        }
    });
});