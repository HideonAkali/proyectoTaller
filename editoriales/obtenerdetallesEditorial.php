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

    // Verificar si el ID de la editorial está presente en la solicitud
    if (isset($_GET['id'])) {
        $editorialID = $_GET['id'];

        // Obtener los detalles de la editorial
        $stmt = $conn->prepare("SELECT nombre, pais, ciudad, direccion, correo, telefono FROM editorial WHERE id = :id");
        $stmt->bindParam(':id', $editorialID, PDO::PARAM_INT);
        $stmt->execute();
        $editorial = $stmt->fetch(PDO::FETCH_ASSOC);

        // Devolver los detalles de la editorial como JSON
        echo json_encode($editorial);
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión
$conn = null;
?>
