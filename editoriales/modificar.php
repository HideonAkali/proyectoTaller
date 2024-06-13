<?php
session_start();

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
            // Mensaje de éxito
            $message = "<div class='alert alert-primary' role='alert'>Los datos se han modificado correctamente.</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error al modificar la editorial.</div>";
        }
    }

    // Redirigir de vuelta a la página de modificación con el mensaje
    header("Location: modificarEditorial.php");
    exit();
} catch (PDOException $e) {
    $_SESSION['message'] = "Error: " . $e->getMessage();
    $_SESSION['message_type'] = "danger";
    header("Location: modificarEditorial.php");
    exit();
}

// Cerrar la conexión
$conn = null;
