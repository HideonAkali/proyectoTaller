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

    // Verificar si el ID del autor está presente en la solicitud
    if (isset($_GET['id'])) {
        $autorID = $_GET['id'];

        // Obtener los detalles del autor
        $stmt = $conn->prepare("SELECT id, nombre, apellido, nacionalidad FROM autor WHERE id = :id");
        $stmt->bindParam(':id', $autorID, PDO::PARAM_INT);
        $stmt->execute();
        $autor = $stmt->fetch(PDO::FETCH_ASSOC);

        // Devolver los detalles del autor como JSON
        echo json_encode($autor);
        exit; // Importante: detener la ejecución después de enviar JSON
    }

    // Verificar si el formulario ha sido enviado para modificar un autor
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $autorID = $_POST['autorID'];
        $nombreAutor = $_POST['nombreAutor'];
        $apellidoAutor = $_POST['apellidoAutor'];
        $nacionalidadAutor = $_POST['nacionalidadAutor'];

        // Preparar la declaración SQL para modificar el autor
        $stmt = $conn->prepare("UPDATE autor SET nombre = :nombreAutor, apellido = :apellidoAutor, nacionalidad = :nacionalidadAutor WHERE id = :autorID");
        $stmt->bindParam(':autorID', $autorID, PDO::PARAM_INT);
        $stmt->bindParam(':nombreAutor', $nombreAutor, PDO::PARAM_STR);
        $stmt->bindParam(':apellidoAutor', $apellidoAutor, PDO::PARAM_STR);
        $stmt->bindParam(':nacionalidadAutor', $nacionalidadAutor, PDO::PARAM_STR);
    }

    // Obtener todos los autores de la base de datos
    $stmt = $conn->prepare("SELECT id, nombre, apellido, nacionalidad FROM autor");
    $stmt->execute();
    $autores = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Mantenedor de Autores</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Estilos/paginas.css" rel="stylesheet">
    <style>
        /* Estilo adicional para la tabla y filtros */
        .table-responsive {
            margin-top: 20px;
        }

        .filter-form {
            margin-bottom: 20px;
        }
    </style>
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
                    <a href="../consultarUsuario.html" class="list-group-item list-group-item-action">Consultar
                        Usuario</a>
                    <a href="../consultarCatalogo.html" class="list-group-item list-group-item-action">Consultar Catálogo</a>
                    <a href="../consultarPrestamos.html" class="list-group-item list-group-item-action">Consultar Préstamos</a>
                    <a href="../calcularMultas.html" class="list-group-item list-group-item-action">Módulo para Calcular y Cobrar Multas</a>
                    <a href="../reportes.html" class="list-group-item list-group-item-action">Módulo de Reportes</a>
                    <a href="../prorroga.html" class="list-group-item list-group-item-action">Prorroga</a>
                    <a href="../editoriales/modificarEditorial.php" class="list-group-item list-group-item-action">Mantenedor de Editoriales</a>
                    <a href="../libro/modificar.php" class="list-group-item list-group-item-action ">Mantenedor de
                        Libros</a>
                    <a href="../genero/agregar.php" class="list-group-item list-group-item-action">Mantenedor
                        Genero</a>
                    <a href="../autor/agregar.php" class="list-group-item list-group-item-action active">Mantenedor
                        Autor</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="content">
                    <h2 class="text-center">Interfaz de Mantenedor de Autores</h2>
                    <ul class="list-group list-group-horizontal text-center justify-content-center mb-4">
                        <li class="list-group-item list-group-item-action p-1"><a href="modificar.php">Modificar</a>
                        </li>
                        <li class="list-group-item list-group-item-action p-1"><a href="eliminar.php">Eliminar</a></li>
                        <li class="list-group-item list-group-item-action p-1"><a href="agregar.php">Agregar</a></li>
                    </ul>

                    <div class="content">
                        <h2 class="text-center">MODIFICAR AUTOR</h2>

                        <!-- Formulario de filtros -->
                        <form id="filterForm" class="filter-form">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <input type="text" class="form-control" id="nombreFilter" placeholder="Filtrar por Nombre">
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" class="form-control" id="apellidoFilter" placeholder="Filtrar por Apellido">
                                </div>
                                <div class="form-group col-md-4">

                                    <input type="text" class="form-control" id="nacionalidadFilter" placeholder="Filtrar por Nacionalidad">
                                </div>
                            </div>
                        </form>

                        <!-- Tabla para mostrar los autores -->
                        <div class="table-responsive">
                            <table id="tablaAutores" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Nacionalidad</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($autores as $autor) : ?>
                                        <tr>
                                            <td><?php echo $autor['id']; ?></td>
                                            <td><?php echo $autor['nombre']; ?></td>
                                            <td><?php echo $autor['apellido']; ?></td>
                                            <td><?php echo $autor['nacionalidad']; ?></td>
                                            <td>
                                                <button class="btn btn-primary" onclick="cargarDetallesAutor(<?php echo $autor['id']; ?>)">Modificar</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Formulario para modificar autores -->
                        <form id="formModificarAutor" action="modificar.php" method="post" class="p-3 border rounded">
                            <?php echo $message; ?> <!-- Mostrar mensaje de éxito/error -->
                            <input type="hidden" id="autorID" name="autorID">
                            <div class="form-group mb-4">
                                <label for="nombreAutor" class="mb-1">Nombre del Autor</label>
                                <input type="text" class="form-control" id="nombreAutor" name="nombreAutor" required>
                            </div>
                            <div class="form-group mb-4">
                                <label for="apellidoAutor" class="mb-1">Apellido del Autor</label>
                                <input type="text" class="form-control" id="apellidoAutor" name="apellidoAutor" required>
                            </div>
                            <div class="form-group mb-4">
                                <label for="nacionalidadAutor" class="mb-1">Nacionalidad del Autor</label>
                                <input type="text" class="form-control" id="nacionalidadAutor" name="nacionalidadAutor" required>
                            </div>

                            <!-- Botón para enviar el formulario -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../autor/js/modificar.js"></script>

</body>

</html>