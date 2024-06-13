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

    // Verificar si el ID del género está presente en la solicitud GET
    if (isset($_GET['id'])) {
        $generoID = $_GET['id'];

        // Obtener los detalles del género
        $stmt = $conn->prepare("SELECT id, nombre FROM genero WHERE id = :id");
        $stmt->bindParam(':id', $generoID, PDO::PARAM_INT);
        $stmt->execute();
        $genero = $stmt->fetch(PDO::FETCH_ASSOC);

        // Devolver los detalles del género como JSON
        echo json_encode($genero);
    } else {
        echo json_encode(array('error' => 'No se recibió el ID del género'));
    }

} catch(PDOException $e) {
    echo json_encode(array('error' => 'Error: ' . $e->getMessage()));
}

// Cerrar la conexión
$conn = null;
?>
