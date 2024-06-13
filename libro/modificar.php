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

    // Verificar si el formulario ha sido enviado para modificar un libro
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtener los datos del formulario
        $libroID = $_POST['libroID'];
        $fechaPublicacion = $_POST['fechaPublicacion'];
        $cantidadPaginas = $_POST['cantidadPaginas'];
        $stock = $_POST['stock'];

        // Preparar la declaración SQL para modificar el libro
        $stmt = $conn->prepare("UPDATE libro SET fecha_publicacion = :fechaPublicacion, cantidad_paginas = :cantidadPaginas, stock = :stock WHERE id = :id");
        $stmt->bindParam(':id', $libroID, PDO::PARAM_INT);
        $stmt->bindParam(':fechaPublicacion', $fechaPublicacion, PDO::PARAM_STR);
        $stmt->bindParam(':cantidadPaginas', $cantidadPaginas, PDO::PARAM_INT);
        $stmt->bindParam(':stock', $stock, PDO::PARAM_INT);

        // Ejecutar la declaración SQL
        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>Libro modificado correctamente.</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error al modificar el libro.</div>";
        }
    }

    // Consultar todos los libros
    $sql = "SELECT id, titulo, fecha_publicacion, cantidad_paginas, stock FROM libro";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    <a href="../editoriales/modificarEditorial.php" class="list-group-item list-group-item-action">Mantenedor de Editoriales</a>
                    <a href="../libro/modificar.php" class="list-group-item list-group-item-action active">Mantenedor de Libros</a>
                    <a href="../genero/agregar.php" class="list-group-item list-group-item-action">Mantenedor Genero</a>
                    <a href="../autor/agregar.php" class="list-group-item list-group-item-action ">Mantenedor Autor</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="content">
                    <h2 class="text-center">Interfaz de Mantenedor de Libros</h2>
                    <?php echo $message; ?> <!-- Aquí se mostrará el mensaje de éxito o error -->
                    <ul class="list-group list-group-horizontal text-center justify-content-center mb-4">
                        <li class="list-group-item list-group-item-action p-1"><a href="modificar.php">Modificar</a></li>
                        <li class="list-group-item list-group-item-action p-1"><a href="eliminar.php">Eliminar</a></li>
                        <li class="list-group-item list-group-item-action p-1"><a href="agregar.php">Agregar</a></li>
                    </ul>

                    <div class="content">
                        <h2 class="text-center">MODIFICAR LIBRO</h2>

                        <!-- Formulario de búsqueda -->
                        <form method="get" class="mb-4">
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <input type="text" class="form-control" id="buscarLibro" name="buscarLibro" placeholder="Buscar por Título" onkeyup="filtrarLibros()">
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="text" class="form-control" id="buscarFecha" name="buscarFecha" placeholder="Buscar por Fecha" onkeyup="filtrarLibros()">
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="text" class="form-control" id="buscarPaginas" name="buscarPaginas" placeholder="Buscar por Páginas" onkeyup="filtrarLibros()">
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="text" class="form-control" id="buscarStock" name="buscarStock" placeholder="Buscar por Stock" onkeyup="filtrarLibros()">
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="text" class="form-control" id="buscarID" name="buscarID" placeholder="Buscar por ID" onkeyup="filtrarLibros()">
                                </div>
                            </div>
                        </form>

                        <!-- Tabla para mostrar los libros -->
                        <div class="table-responsive">
                            <table class="table table-striped" id="tablaLibros">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Título</th>
                                        <th>Fecha de Publicación</th>
                                        <th>Cantidad de Páginas</th>
                                        <th>Stock</th>
                                        <th>Modificar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($libros as $libro) : ?>
                                        <tr>
                                            <td><?php echo $libro['id']; ?></td>
                                            <td><?php echo $libro['titulo']; ?></td>
                                            <td><?php echo $libro['fecha_publicacion']; ?></td>
                                            <td><?php echo $libro['cantidad_paginas']; ?></td>
                                            <td><?php echo $libro['stock']; ?></td>
                                            <td><button class="btn btn-primary" onclick="cargarDetallesLibro(<?php echo $libro['id']; ?>)">Modificar</button></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Formulario para modificar libros -->
                        <form action="modificar.php" method="post" class="p-3 border rounded">
                            <input type="hidden" id="libroID" name="libroID">
                            <div class="form-group mb-4">
                                <label for="fechaPublicacion" class="mb-1">Fecha de Publicación</label>
                                <input type="date" class="form-control" id="fechaPublicacion" name="fechaPublicacion" required>
                            </div>
                            <div class="form-group mb-4">
                                <label for="cantidadPaginas" class="mb-1">Cantidad de Páginas</label>
                                <input type="number" class="form-control" id="cantidadPaginas" name="cantidadPaginas" required>
                            </div>
                            <div class="form-group mb-4">
                                <label for="stock" class="mb-1">Stock</label>
                                <input type="number" class="form-control" id="stock" name="stock" required>
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
    <script>
        function cargarDetallesLibro(libroID) {
            if (libroID) {
                $.ajax({
                    url: 'obtenerDetallesLibro.php',
                    type: 'GET',
                    data: {
                        id: libroID
                    },
                    success: function(response) {
                        var libro = JSON.parse(response);
                        document.getElementById('libroID').value = libroID;
                        document.getElementById('fechaPublicacion').value = libro.fecha_publicacion;
                        document.getElementById('cantidadPaginas').value = libro.cantidad_paginas;
                        document.getElementById('stock').value = libro.stock;
                    }
                });
            }
        }

        function filtrarLibros() {
            var buscarTitulo = document.getElementById('buscarLibro').value.toLowerCase();
            var buscarFecha = document.getElementById('buscarFecha').value.toLowerCase();
            var buscarPaginas = document.getElementById('buscarPaginas').value;
            var buscarStock = document.getElementById('buscarStock').value;
            var buscarID = document.getElementById('buscarID').value;

            var table = document.getElementById('tablaLibros');
            var tr = table.getElementsByTagName('tr');

            for (var i = 1; i < tr.length; i++) {
                var tdTitulo = tr[i].getElementsByTagName('td')[1];
                var tdFecha = tr[i].getElementsByTagName('td')[2];
                var tdPaginas = tr[i].getElementsByTagName('td')[3];
                var tdStock = tr[i].getElementsByTagName('td')[4];
                var tdID = tr[i].getElementsByTagName('td')[0];

                if (tdTitulo && tdFecha && tdPaginas && tdStock && tdID) {
                    var txtTitulo = tdTitulo.textContent.toLowerCase();
                    var txtFecha = tdFecha.textContent.toLowerCase();
                    var txtPaginas = tdPaginas.textContent;
                    var txtStock = tdStock.textContent;
                    var txtID = tdID.textContent;

                    if (txtTitulo.includes(buscarTitulo) && txtFecha.includes(buscarFecha) && (buscarPaginas === '' || txtPaginas.includes(buscarPaginas)) && (buscarStock === '' || txtStock.includes(buscarStock)) && (buscarID === '' || txtID.includes(buscarID))) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        }
    </script>
</body>

</html>
