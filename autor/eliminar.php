<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca";

try {
    // Crear una nueva conexión PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Establecer el modo de error PDO a excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar si se envió el formulario para eliminar un autor
    if (isset($_POST['eliminarAutor'])) {
        // Obtener el ID del autor desde el formulario
        $autorID = $_POST['autorID'];

        // Preparar la declaración SQL para eliminar el autor
        $stmt = $conn->prepare("DELETE FROM autor WHERE id = :id");
        $stmt->bindParam(':id', $autorID, PDO::PARAM_INT);

        // Ejecutar la declaración SQL
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Autor eliminado exitosamente.</div>";
        } else {
            echo "<div class='alert alert-danger'>Error al eliminar el autor.</div>";
        }
    }
    // Obtener todos los autores de la base de datos
    $stmtAutores = $conn->query("SELECT id, nombre FROM autor");
    $autores = $stmtAutores->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Eliminar Autor</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Estilos/paginas.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                    <a href="../libro/modificar.php" class="list-group-item list-group-item-action">Mantenedor de Libros</a>
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

                    <div class="content">
                        <h2 class="text-center">Eliminar Autor</h2>
                        <!-- Formulario para eliminar autores -->
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-3 border rounded" id="formEliminarAutor">
                            <div class="form-group mb-4">
                                <label for="autorID" class="mb-1">Seleccionar Autor</label>
                                <select class="form-control" id="autorID" name="autorID" required>
                                    <option value="">Seleccionar Autor</option>
                                    <?php foreach ($autores as $autor) : ?>
                                        <option value="<?php echo $autor['id']; ?>"><?php echo $autor['nombre']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Botón para enviar el formulario -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-danger" name="eliminarAutor">Eliminar Autor</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="../autor/js/eliminar.js"></script>
        
</body>

</html>
