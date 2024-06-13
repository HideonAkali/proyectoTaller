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

    // Verificar si el ID del libro está presente en la solicitud
    if (isset($_GET['id'])) {
        $libroID = $_GET['id'];

        // Obtener los detalles del libro
        $stmt = $conn->prepare("SELECT fecha_publicacion, cantidad_paginas, stock FROM libro WHERE id = :id");
        $stmt->bindParam(':id', $libroID, PDO::PARAM_INT);
        $stmt->execute();
        $libro = $stmt->fetch(PDO::FETCH_ASSOC);

        // Devolver los detalles del libro como JSON
        echo json_encode($libro);
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Cerrar la conexión
$conn = null;
?>
