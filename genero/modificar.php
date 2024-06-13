<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca";

$message = ""; // Variable para almacenar el mensaje de éxito o error

try {
    // Crear una nueva conexión PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Establecer el modo de error PDO a excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si el formulario ha sido enviado para modificar un género
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $generoID = $_POST['generoID'];
        $nombreGenero = $_POST['nombreGenero'];

        // Preparar la declaración SQL para modificar el género
        $stmt = $conn->prepare("UPDATE genero SET nombre = :nombreGenero WHERE id = :generoID");
        $stmt->bindParam(':generoID', $generoID, PDO::PARAM_INT);
        $stmt->bindParam(':nombreGenero', $nombreGenero, PDO::PARAM_STR);

    }

    // Obtener todos los géneros de la base de datos
    $stmt = $conn->prepare("SELECT id, nombre FROM genero");
    $stmt->execute();
    $generos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión
$conn = null;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenedor de Géneros</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Estilos/paginas.css" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg">
            <a href="index.html">
                <img src="../media/edd.webp" alt="" width="100">
            </a>
            <a class="navbar-brand" href="index.html">Biblioteca Ed, Edd y Eddy</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.html">Inicio <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="acerca.html">Acerca</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contacto.html">Contacto</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="../prestarlibro.html" class="list-group-item list-group-item-action">Prestar Libro</a>
                    <a href="../consultarUsuario.html" class="list-group-item list-group-item-action">Consultar Usuario</a>
                    <a href="../consultarCatalogo.html" class="list-group-item list-group-item-action">Consultar Catálogo</a>
                    <a href="../consultarPrestamos.html" class="list-group-item list-group-item-action">Consultar Préstamos</a>
                    <a href="../calcularMultas.html" class="list-group-item list-group-item-action">Módulo para Calcular y Cobrar Multas</a>
                    <a href="../reportes.html" class="list-group-item list-group-item-action">Módulo de Reportes</a>
                    <a href="../prorroga.html" class="list-group-item list-group-item-action">Prorroga</a>
                    <a href="../editoriales/modificarEditorial.php" class="list-group-item list-group-item-action">Mantenedor de Editoriales</a>
                    <a href="../libro/modificar.php" class="list-group-item list-group-item-action ">Mantenedor de Libros</a>
                    <a href="../genero/modificar.php" class="list-group-item list-group-item-action active">Mantenedor Genero</a>
                    <a href="../autor/agregar.php" class="list-group-item list-group-item-action">Mantenedor Autor</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="content">
                    <h2 class="text-center">Interfaz de Mantenedor de Géneros</h2>
                    <ul class="list-group list-group-horizontal text-center justify-content-center mb-4">
                        <li class="list-group-item list-group-item-action p-1"><a href="modificar.php">Modificar</a></li>
                        <li class="list-group-item list-group-item-action p-1"><a href="eliminar.php">Eliminar</a></li>
                        <li class="list-group-item list-group-item-action p-1"><a href="agregar.php">Agregar</a></li>
                    </ul>

                    <div class="content">
                        <h2 class="text-center">MODIFICAR GÉNERO</h2>

                        <!-- Filtros -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <input type="text" id="nombreFilter" class="form-control" placeholder="Filtrar por Nombre">
                            </div>
                        </div>

                        <!-- Tabla para mostrar los géneros -->
                        <div class="table-responsive">
                            <table class="table table-striped" id="tablaGeneros">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($generos as $genero) : ?>
                                        <tr>
                                            <td><?php echo $genero['id']; ?></td>
                                            <td><?php echo $genero['nombre']; ?></td>
                                            <td>
                                                <button class="btn btn-primary" onclick="cargarDetallesGenero(<?php echo $genero['id']; ?>)">Modificar</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Formulario para modificar géneros -->
                        <form id="formModificarGenero" action="modificar.php" method="post" class="p-3 border rounded"><?php echo $message; ?>
                            <input type="hidden" id="generoID" name="generoID">
                            <div class="form-group mb-4">
                                <label for="nombreGenero" class="mb-1">Nombre del Género</label>
                                <input type="text" class="form-control" id="nombreGenero" name="nombreGenero" required>
                            </div>

                            <!-- Botón para enviar el formulario -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Modificar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function cargarDetallesGenero(generoID) {
            if (generoID) {
                $.ajax({
                    url: 'obtenerdatos.php',
                    type: 'GET',
                    data: {
                        id: generoID
                    },
                    success: function(response) {
                        var genero = JSON.parse(response);
                        document.getElementById('generoID').value = genero.id;
                        document.getElementById('nombreGenero').value = genero.nombre;
                    },
                    error: function(xhr, status, error) {
                        console.error("Error al cargar los detalles del género:", error);
                    }
                });
            }
        }

        // Script para el formulario de modificación de géneros
        document.getElementById('formModificarGenero').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevenir la sumisión del formulario por defecto

            var nombreGenero = document.getElementById('nombreGenero').value;

            Swal.fire({
                title: "¿Estás seguro?",
                html: `Vas a modificar los datos del género a:<br><br>
                      <strong>Nombre:</strong> ${nombreGenero}<br><br>
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
                        text: "El género ha sido modificado.",
                        icon: "success"
                    }).then(() => {
                        // Continuar con la sumisión del formulario
                        event.target.submit();
                    });
                }
            });
        });

        // Función para filtrar la tabla de géneros
        function filtrarTabla() {
            var inputNombre = document.getElementById("nombreFilter").value.toUpperCase();
            var tabla = document.getElementById("tablaGeneros");
            var filas = tabla.getElementsByTagName("tr");

            // Recorrer todas las filas y ocultar las que no cumplen con los filtros
            for (var i = 1; i < filas.length; i++) { // Iniciar desde 1 para saltar la fila de encabezado
                var celdas = filas[i].getElementsByTagName("td");
                var mostrarFila = true;

                // Comparar cada celda con los filtros
                if (celdas.length > 0) {
                    var nombre = celdas[1].textContent.toUpperCase();

                    if (inputNombre && nombre.indexOf(inputNombre) === -1) {
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
    </script>

</body>

</html>
