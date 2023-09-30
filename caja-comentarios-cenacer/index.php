<?php

// Configurar cabeceras CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Conexión a la base de datos MySQL
$servername = "localhost"; // Cambia esto a la dirección de tu servidor de base de datos si es diferente
$username = "id21302362_admin"; // Cambia esto a tu nombre de usuario de la base de datos
$password = "Cenacer1."; // Cambia esto a tu contraseña de la base de datos
$dbname = "id21302362_cursosagosto"; // Cambia esto a tu nombre de base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si la solicitud es de tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener datos enviados por el cliente
    $data = json_decode(file_get_contents('php://input'), true);

    // Obtener los campos del comentario
    $nombre = $data['nombre'];
    $comentario = $data['comentario'];

    // Crear una consulta SQL para insertar el comentario en la base de datos
    $sql = "INSERT INTO Com_CursosAgosto (nombre, comentario) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error en la consulta: " . $conn->error);
    }

    $stmt->bind_param("ss", $nombre, $comentario);

    if ($stmt->execute() === true) {
        // El comentario se ha guardado correctamente
        $response = ['mensaje' => 'Comentario creado con éxito'];
    } else {
        // Ha ocurrido un error al guardar el comentario
        $response = ['error' => 'Error al guardar el comentario en la base de datos: ' . $conn->error];
    }

    // Enviar una respuesta al cliente
    header('Content-Type: application/json');
    echo json_encode($response);

    // Cerrar la conexión a la base de datos
    $stmt->close();
    $conn->close();
} else {
    // Manejar otros métodos HTTP o mostrar un error si es necesario
    http_response_code(405); // Método no permitido
    echo json_encode(['error' => 'Método no permitido']);
}
?>

