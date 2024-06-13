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
  // Obtener datos del formulario de LIBRO
  $tituloLibro = $_POST['tituloLibro'];
  $fechaPublicacion = $_POST['fechaPublicacion'];
  $cantidadPaginas = $_POST['cantidadPaginas'];
  $stock = $_POST['stock'];
  $autorID = $_POST['autorID'];
  $editorialID = $_POST['editorialID'];
  $generoID = $_POST['generoID'];

  // Inicializar el mensaje de salida
  $mensaje = "";

  // Insertar en la tabla LIBRO
  $stmtLibro = $conn->prepare("INSERT INTO libro (titulo, fecha_publicacion, cantidad_paginas, stock, autor_id, editorial_id, genero_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmtLibro->bind_param("ssiiiii", $tituloLibro, $fechaPublicacion, $cantidadPaginas, $stock, $autorID, $editorialID, $generoID);
  $stmtLibro->execute();
  if ($stmtLibro->affected_rows > 0) {
    $mensaje .= "Libro registrado exitosamente.";
  } else {
    $mensaje .= "Error al registrar el libro.";
  }

  // Cerrar la consulta
  $stmtLibro->close();
}

// Obtener autores, editoriales y géneros de la base de datos
$autores = $conn->query("SELECT id, nombre, apellido FROM autor");
$editoriales = $conn->query("SELECT id, nombre FROM editorial");
$generos = $conn->query("SELECT id, nombre FROM genero");

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
                    <a href="../editoriales/modificarEditorial.php" class="list-group-item list-group-item-action">Mantenedor de Editoriales</a>
                    <a href="../libro/modificar.php" class="list-group-item list-group-item-action active">Mantenedor de Libros</a>
                    <a href="../genero/agregar.php" class="list-group-item list-group-item-action">Mantenedor Genero</a>
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
          <form action="" method="post" class="p-3 border rounded">
            <div class="row">
              <div class="col-md-6 mb-4">
                <!-- Sección AUTOR -->
                <div class="form-group mb-2">
                  <label for="autorID" class="mb-1">AUTOR</label>
                  <select class="form-control form-control-sm" id="autorID" name="autorID" required>
                    <?php while ($row = $autores->fetch_assoc()) { ?>
                      <option value="<?php echo $row['id']; ?>">
                        <?php echo $row['nombre'] . " " . $row['apellido']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <!-- Sección EDITORIAL -->
                <div class="form-group mb-2">
                  <label for="editorialID" class="mb-1">EDITORIAL</label>
                  <select class="form-control form-control-sm" id="editorialID" name="editorialID" required>
                    <?php while ($row = $editoriales->fetch_assoc()) { ?>
                      <option value="<?php echo $row['id']; ?>">
                        <?php echo $row['nombre']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb-4">
                <!-- Sección GENERO -->
                <div class="form-group mb-2">
                  <label for="generoID" class="mb-1">GENERO</label>
                  <select class="form-control form-control-sm" id="generoID" name="generoID" required>
                    <?php while ($row = $generos->fetch_assoc()) { ?>
                      <option value="<?php echo $row['id']; ?>">
                        <?php echo $row['nombre']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6 mb-4">
                <!-- Sección LIBRO -->
                <h3 class="h5">LIBRO</h3>
                <div class="form-group mb-2">
                  <label for="tituloLibro" class="mb-1">TITULO</label>
                  <input type="text" class="form-control form-control-sm" id="tituloLibro" name="tituloLibro" required>
                </div>
                <div class="form-group mb-2">
                  <label for="fechaPublicacion" class="mb-1">FECHA PUBLICACION</label>
                  <input type="date" class="form-control form-control-sm" id="fechaPublicacion" name="fechaPublicacion" required>
                </div>
                <div class="form-group mb-2">
                  <label for="cantidadPaginas" class="mb-1">CANTIDAD DE PAGINAS</label>
                  <input type="number" class="form-control form-control-sm" id="cantidadPaginas" name="cantidadPaginas" required>
                </div>
                <div class="form-group mb-2">
                  <label for="stock" class="mb-1">STOCK</label>
                  <input type="number" class="form-control form-control-sm" id="stock" name="stock" required>
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