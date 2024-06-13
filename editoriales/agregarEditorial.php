<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca";

// Mostrar todos los errores de PHP (desactivar en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario de EDITORIAL
    $nombreEditorial = $_POST['nombreEditorial'];
    $paisEditorial = $_POST['paisEditorial'];
    $ciudadEditorial = $_POST['ciudadEditorial'];
    $direccionEditorial = $_POST['direccionEditorial'];
    $correoEditorial = $_POST['correoEditorial'];
    $telefonoEditorial = $_POST['telefonoEditorial'];

    // Inicializar el mensaje de salida
    $mensaje = "";

    // Insertar en la tabla EDITORIAL
    $stmtEditorial = $conn->prepare("INSERT INTO editorial (nombre, pais, ciudad, direccion, correo, telefono) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmtEditorial === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmtEditorial->bind_param("ssssss", $nombreEditorial, $paisEditorial, $ciudadEditorial, $direccionEditorial, $correoEditorial, $telefonoEditorial);
    if ($stmtEditorial->execute()) {
        $mensaje .= "Editorial registrada exitosamente. ";
    } else {
        $mensaje .= "Error al registrar la editorial: " . $stmtEditorial->error;
    }

    // Cerrar las consultas
    $stmtEditorial->close();
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
                    <a href="../editoriales/modificarEditorial.php" class="list-group-item list-group-item-action active">Mantenedor de Editoriales</a>
                    <a href="../libro/modificar.php" class="list-group-item list-group-item-action ">Mantenedor de Libros</a>
                    <a href="../genero/agregar.php" class="list-group-item list-group-item-action">Mantenedor Genero</a>
                    <a href="../autor/agregar.php" class="list-group-item list-group-item-action ">Mantenedor Autor</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="content">
                    <h2 class="text-center">Interfaz de Mantenedor de Libros</h2>
                    <ul class="list-group list-group-horizontal text-center justify-content-center mb-4">
                        <li class="list-group-item list-group-item-action p-1"><a href="modificarEditorial.php">Modificar</a></li>
                        <li class="list-group-item list-group-item-action p-1"><a href="eliminarEditorial.php">Eliminar</a></li>
                        <li class="list-group-item list-group-item-action p-1"><a href="agregarEditorial.php">Agregar</a></li>
                    </ul>

                    <!-- Formulario único para todos los datos -->
                    <form action="" method="post" class="p-3 border rounded">
                        <!-- Sección EDITORIAL -->
                        <h3 class="h5">EDITORIAL</h3>
                        <div class="form-group mb-2">
                            <label for="nombreEditorial" class="mb-1">NOMBRE</label>
                            <input type="text" class="form-control form-control-sm" id="nombreEditorial" name="nombreEditorial" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="paisEditorial" class="mb-1">PAIS</label>
                            <input type="text" class="form-control form-control-sm" id="paisEditorial" name="paisEditorial" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="ciudadEditorial" class="mb-1">CIUDAD</label>
                            <input type="text" class="form-control form-control-sm" id="ciudadEditorial" name="ciudadEditorial" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="direccionEditorial" class="mb-1">DIRECCION</label>
                            <input type="text" class="form-control form-control-sm" id="direccionEditorial" name="direccionEditorial" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="correoEditorial" class="mb-1">CORREO</label>
                            <input type="email" class="form-control form-control-sm" id="correoEditorial" name="correoEditorial" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="telefonoEditorial" class="mb-1">TELEFONO</label>
                            <input type="text" class="form-control form-control-sm" id="telefonoEditorial" name="telefonoEditorial" required>
                        </div>
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
    <script src="js/json.js"></script>
</body>

</html>