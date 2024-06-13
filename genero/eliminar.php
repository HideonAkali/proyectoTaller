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

  // Verificar si se envió el formulario para eliminar un género
  if (isset($_POST['eliminarGenero'])) {
    // Obtener el ID del género desde el formulario
    $generoID = $_POST['generoID'];

    // Preparar la declaración SQL para eliminar el género
    $stmt = $conn->prepare("DELETE FROM genero WHERE id = :id");
    $stmt->bindParam(':id', $generoID, PDO::PARAM_INT);

    // Ejecutar la declaración SQL
    if ($stmt->execute()) {
      echo "<div class='alert alert-success'>Género eliminado exitosamente.</div>";
    } else {
      echo "<div class='alert alert-danger'>Error al eliminar el género.</div>";
    }
  }

  // Obtener todos los géneros de la base de datos
  $stmtGeneros = $conn->query("SELECT id, nombre FROM genero");
  $generos = $stmtGeneros->fetchAll(PDO::FETCH_ASSOC);

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
  <title>Eliminar Géneros</title>

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
          <a href="../libro/modificar.php" class="list-group-item list-group-item-action">Mantenedor de Libros</a>
          <a href="../genero/agregar.php" class="list-group-item list-group-item-action active">Mantenedor de Géneros</a>
          <a href="../autor/agregar.php" class="list-group-item list-group-item-action">Mantenedor de Autor</a>
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
            <h2 class="text-center">Eliminar Géneros</h2>

            <!-- Formulario para eliminar géneros -->
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="p-3 border rounded">
              <div class="form-group mb-4">
                <label for="generoID" class="mb-1">Seleccionar Género</label>
                <select class="form-control" id="generoID" name="generoID" required>
                  <option value="">Seleccionar Género</option>
                  <?php foreach ($generos as $genero) : ?>
                    <option value="<?php echo $genero['id']; ?>"><?php echo $genero['nombre']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <!-- Botón para enviar el formulario -->
              <div class="text-center">
                <button type="submit" class="btn btn-danger" name="eliminarGenero">Eliminar Género</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>document.addEventListener('DOMContentLoaded', function() {
    // Función para mostrar la alerta de confirmación
    function confirmarEliminacion(event) {
        event.preventDefault();
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminarlo!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.querySelector('form').submit();
            }
        });
    }

    // Adjuntar el evento al botón de eliminación
    const eliminarBtn = document.querySelector('button[name="eliminarGenero"]');
    if (eliminarBtn) {
        eliminarBtn.addEventListener('click', confirmarEliminacion);
    }

    // Función para mostrar la alerta de éxito
    function mostrarAlertaExito(mensaje) {
        Swal.fire({
            title: 'Eliminado!',
            text: mensaje,
            icon: 'success',
            confirmButtonText: 'OK'
        });
    }

    // Función para mostrar la alerta de error
    function mostrarAlertaError(mensaje) {
        Swal.fire({
            title: 'Error!',
            text: mensaje,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }

    // Verificar si hay una alerta de éxito o error en el servidor
    const alertaExito = document.querySelector('.alert-success');
    if (alertaExito) {
        mostrarAlertaExito(alertaExito.textContent);
    }

    const alertaError = document.querySelector('.alert-danger');
    if (alertaError) {
        mostrarAlertaError(alertaError.textContent);
    }
});
</script>

    
</body>

</html>

