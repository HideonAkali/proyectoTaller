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

    // Verificar si el formulario ha sido enviado para modificar una editorial
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modificar'])) {
        // Obtener los datos del formulario
        $editorialID = $_POST['editorialID'];
        $nombre = $_POST['nombre'];
        $pais = $_POST['pais'];
        $ciudad = $_POST['ciudad'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];

        // Preparar la declaración SQL para modificar la editorial
        $stmt = $conn->prepare("UPDATE editorial SET nombre = :nombre, pais = :pais, ciudad = :ciudad, direccion = :direccion, telefono = :telefono WHERE id = :id");
        $stmt->bindParam(':id', $editorialID, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':pais', $pais, PDO::PARAM_STR);
        $stmt->bindParam(':ciudad', $ciudad, PDO::PARAM_STR);
        $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);

        // Ejecutar la declaración SQL
        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>Editorial modificada correctamente.</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error al modificar la editorial.</div>";
        }
    }

    // Consultar todas las editoriales
    $sql = "SELECT id, nombre, pais, ciudad, direccion, telefono FROM editorial";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $editoriales = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Mantenedor de Editoriales</title>
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
                    <h2 class="text-center">Interfaz de Mantenedor de Editoriales</h2>
                    <?php echo $message; ?> <!-- Aquí se mostrará el mensaje de éxito o error -->
                    <ul class="list-group list-group-horizontal text-center justify-content-center mb-4">
                        <li class="list-group-item list-group-item-action p-1"><a href="modificarEditorial.php">Modificar</a></li>
                        <li class="list-group-item list-group-item-action p-1"><a href="eliminarEditorial.php">Eliminar</a></li>
                        <li class="list-group-item list-group-item-action p-1"><a href="agregarEditorial.php">Agregar</a></li>

                    </ul>

                    <div class="content">
                        <h2 class="text-center">MODIFICAR EDITORIAL</h2>

                        <!-- Formulario de búsqueda -->
                        <form method="get" class="mb-4">
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label for="searchName">Buscar por Nombre</label>
                                    <input type="text" class="form-control" id="searchName" name="searchName" onkeyup="filtrarTabla()">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="searchPais">Buscar por País</label>
                                    <input type="text" class="form-control" id="searchPais" name="searchPais" onkeyup="filtrarTabla()">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="searchCiudad">Buscar por Ciudad</label>
                                    <input type="text" class="form-control" id="searchCiudad" name="searchCiudad" onkeyup="filtrarTabla()">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="searchDireccion">Buscar por Dirección</label>
                                    <input type="text" class="form-control" id="searchDireccion" name="searchDireccion" onkeyup="filtrarTabla()">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="searchTelefono">Buscar por Teléfono</label>
                                    <input type="text" class="form-control" id="searchTelefono" name="searchTelefono" onkeyup="filtrarTabla()">
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="searchID">Buscar por ID</label>
                                    <input type="number" class="form-control" id="searchID" name="searchID" onkeyup="filtrarTabla()">
                                </div>
                            </div>
                        </form>

                        <!-- Tabla para mostrar las editoriales -->
                        <div class="table-responsive">
                            <table class="table table-striped" id="tablaEditoriales">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>País</th>
                                        <th>Ciudad</th>
                                        <th>Dirección</th>
                                        <th>Teléfono</th>
                                        <th>Modificar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($editoriales as $editorial) : ?>
                                        <tr>
                                            <td><?php echo $editorial['id']; ?></td>
                                            <td><?php echo $editorial['nombre']; ?></td>
                                            <td><?php echo $editorial['pais']; ?></td>
                                            <td><?php echo $editorial['ciudad']; ?></td>
                                            <td><?php echo $editorial['direccion']; ?></td>
                                            <td><?php echo $editorial['telefono']; ?></td>
                                            <td><button class="btn btn-primary" onclick="cargarDetallesEditorial(<?php echo $editorial['id']; ?>)">Modificar</button></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Formulario para modificar editoriales -->
                        <form action="modificar.php" method="post" class="p-3 border rounded">
                            <?php echo $message; ?>
                            <input type="hidden" id="editorialID" name="editorialID">
                            <div class="form-group mb-4">
                                <label for="nombre" class="mb-1">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="form-group mb-4">
                                <label for="pais" class="mb-1">País</label>
                                <input type="text" class="form-control" id="pais" name="pais" required>
                            </div>
                            <div class="form-group mb-4">
                                <label for="ciudad" class="mb-1">Ciudad</label>
                                <input type="text" class="form-control" id="ciudad" name="ciudad" required>
                            </div>
                            <div class="form-group mb-4">
                                <label for="direccion" class="mb-1">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" required>
                            </div>
                            <div class="form-group mb-4">
                                <label for="telefono" class="mb-1">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" required>
                            </div>

                            <!-- Botón para enviar el formulario -->
                            <div class="text-center">
                                <button type="submit" name="modificar" class="btn btn-primary">Modificar</button>
                            </div>
                            <div class="text-center mt-3">
                                <p><?php echo isset($mensaje) ? $mensaje : ''; ?></p>
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
        function cargarDetallesEditorial(editorialID) {
            if (editorialID) {
                $.ajax({
                    url: 'obtenerDetallesEditorial.php',
                    type: 'GET',
                    data: {
                        id: editorialID
                    },
                    success: function(response) {
                        var editorial = JSON.parse(response);
                        document.getElementById('editorialID').value = editorialID;
                        document.getElementById('nombre').value = editorial.nombre;
                        document.getElementById('pais').value = editorial.pais;
                        document.getElementById('ciudad').value = editorial.ciudad;
                        document.getElementById('direccion').value = editorial.direccion;
                        document.getElementById('telefono').value = editorial.telefono;
                    }
                });
            }
        }

        function filtrarTabla() {
            var nombre = document.getElementById('searchName').value.toLowerCase();
            var pais = document.getElementById('searchPais').value.toLowerCase();
            var ciudad = document.getElementById('searchCiudad').value.toLowerCase();
            var direccion = document.getElementById('searchDireccion').value.toLowerCase();
            var telefono = document.getElementById('searchTelefono').value.toLowerCase();
            var id = document.getElementById('searchID').value;

            var table = document.getElementById('tablaEditoriales');
            var tr = table.getElementsByTagName('tr');

            for (var i = 1; i < tr.length; i++) {
                var tdNombre = tr[i].getElementsByTagName('td')[1];
                var tdPais = tr[i].getElementsByTagName('td')[2];
                var tdCiudad = tr[i].getElementsByTagName('td')[3];
                var tdDireccion = tr[i].getElementsByTagName('td')[4];
                var tdTelefono = tr[i].getElementsByTagName('td')[5];
                var tdID = tr[i].getElementsByTagName('td')[0];

                if (tdNombre && tdPais && tdCiudad && tdDireccion && tdTelefono && tdID) {
                    var txtNombre = tdNombre.textContent.toLowerCase();
                    var txtPais = tdPais.textContent.toLowerCase();
                    var txtCiudad = tdCiudad.textContent.toLowerCase();
                    var txtDireccion = tdDireccion.textContent.toLowerCase();
                    var txtTelefono = tdTelefono.textContent.toLowerCase();
                    var txtID = tdID.textContent;

                    if (txtNombre.includes(nombre) && txtPais.includes(pais) && txtCiudad.includes(ciudad) && txtDireccion.includes(direccion) && txtTelefono.includes(telefono) && (id === '' || txtID.includes(id))) {
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