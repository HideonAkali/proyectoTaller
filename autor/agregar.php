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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario de AUTOR
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $nacionalidad = $_POST['nacionalidad'];

    // Inicializar el mensaje de salida
    $mensaje = "";

    // Insertar en la tabla AUTOR
    $stmtAutor = $conn->prepare("INSERT INTO autor (nombre, apellido, nacionalidad) VALUES (?, ?, ?)");
    $stmtAutor->bind_param("sss", $nombre, $apellido, $nacionalidad);
    $stmtAutor->execute();
    if ($stmtAutor->affected_rows > 0) {
        $mensaje = "Autor registrado exitosamente.";
    } else {
        $mensaje = "Error al registrar el autor.";
    }

    // Cerrar la consulta
    $stmtAutor->close();
}
// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenedor de Autores</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Estilos/paginas.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> <!-- Incluir SweetAlert -->
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
                    <a href="../genero/agregar.php" class="list-group-item list-group-item-action">Mantenedor Genero</a>
                    <a href="../autor/agregar.php" class="list-group-item list-group-item-action active">Mantenedor Autor</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="content">
                    <h2 class="text-center">Interfaz de Mantenedor de Autores</h2>
                    <ul class="list-group list-group-horizontal text-center justify-content-center mb-4">
                        <li class="list-group-item list-group-item-action p-1"><a href="modificar.php">Modificar</a></li>
                        <li class="list-group-item list-group-item-action p-1"><a href="eliminar.php">Eliminar</a></li>
                        <li class="list-group-item list-group-item-action p-1"><a href="agregar.php">Agregar</a></li>
                    </ul>

                    <!-- Formulario único para todos los datos -->
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="agregarAutorForm">
                        <div class="col-md-6 mb-4">
                            <!-- Sección AUTOR -->
                            <h3 class="h5">AUTOR</h3>
                            <div class="form-group mb-2">
                                <label for="nombre" class="mb-1">NOMBRE</label>
                                <input type="text" class="form-control form-control-sm" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="apellido" class="mb-1">APELLIDO</label>
                                <input type="text" class="form-control form-control-sm" id="apellido" name="apellido" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="nacionalidad" class="mb-1">NACIONALIDAD</label>
                                <input type="text" class="form-control form-control-sm" id="nacionalidad" name="nacionalidad" required>
                            </div>
                        </div>
                        <!-- Botón para enviar todos los formularios -->
                        <div class="text-center">
                            <button type="button" class="btn btn-primary" onclick="confirmarAgregarAutor()">Enviar</button>
                        </div>
                    </form>

                    <!-- Mensaje de confirmación -->
                    <div class="text-center mt-3">
                        <p id="mensaje"><?php echo isset($mensaje) ? $mensaje : ''; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../autor/js/agregar.js"></script>

</body>

</html>
