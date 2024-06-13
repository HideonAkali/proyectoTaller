<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$mensaje = ""; // Variable para almacenar el mensaje de éxito o error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario de GENERO
    $nombreGenero = $_POST['nombre'];

    // Insertar en la tabla GENERO
    $stmtGenero = $conn->prepare("INSERT INTO genero (nombre) VALUES (?)");
    $stmtGenero->bind_param("s", $nombreGenero);
    $stmtGenero->execute();

    // Cerrar las consultas
    $stmtGenero->close();
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenedor de Libros</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Estilos/paginas.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
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
                    <a href="../genero/agregar.php" class="list-group-item list-group-item-action active">Mantenedor Genero</a>
                    <a href="../autor/agregar.php" class="list-group-item list-group-item-action ">Mantenedor Autor</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="content">
                    <h2 class="text-center">Interfaz de Mantenedor de Libros</h2>
                    <ul class="list-group list-group-horizontal text-center justify-content-center mb-4">
                        <li class="list-group-item list-group-item-action p-1"><a href="modificar.php">Modificar</a></li>
                        <li class="list-group-item list-group-item-action p-1"><a href="eliminar.php">Eliminar</a></li>
                        <li class="list-group-item list-group-item-action p-1"><a href="agregar.php">Agregar</a></li>
                    </ul>

                    <!-- Formulario único para todos los datos -->
                    <form action="" method="post" class="p-3 border rounded" id="formAgregarGenero">
                        <div class="row">
                            <!-- Sección GENERO -->
                            <div class="form-group mb-2">
                                <label for="nombreGenero" class="mb-1">GENERO</label>
                                <input type="text" class="form-control form-control-sm" id="nombreGenero" name="nombre" required>
                            </div>
                        </div>

                        <!-- Botón para enviar todos los formularios -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </form>
                    <!-- Mensaje de confirmación -->
                    <div class="text-center mt-3">
                        <p><?php echo isset($mensaje) ? $mensaje : ''; ?></p>
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
        document.getElementById('formAgregarGenero').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevenir la sumisión del formulario por defecto

            var nombreGenero = document.getElementById('nombreGenero').value;

            Swal.fire({
                title: "¿Estás seguro?",
                text: `Vas a agregar el género "${nombreGenero}".`,
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, agregar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Agregado!',
                        'El género ha sido registrado.',
                        'success'
                    ).then(() => {
                        // Continuar con la sumisión del formulario
                        event.target.submit();
                    });
                }
            });
        });
    </script>
</body>

</html>
