<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Conexión a la base de datos MySQL
$servername = "sql9.freesqldatabase.com"; // Cambia esto a la dirección de tu servidor de base de datos si es diferente
$username = "sql9650488"; // Cambia esto a tu nombre de usuario de la base de datos
$password = "tZz5v5KByk"; // Cambia esto a tu contraseña de la base de datos
$dbname = "sql9650488"; // Cambia esto a tu nombre de base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si la solicitud es de tipo GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') { // Cambio de POST a GET
    // Obtener datos de la URL
    $nombre = $_GET['nombre'];
    $comentario = $_GET['comentario'];

    // Crear una consulta SQL para insertar el comentario en la base de datos
    $sql = "INSERT INTO Com_cenacer_ago_clase1 (nombre, comentario) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error en la consulta: " . $conn->error);
    }

    $stmt->bind_param("ss", $nombre, $comentario);

    if ($stmt->execute() === true) {
        // El comentario se ha guardado correctamente
        $response = ['mensaje' => 'Comentario llegó al endpoint, guardando en base de datos...'];

        // Puedes agregar aquí código adicional para procesar la inserción en la base de datos

        // Verificar si la inserción en la base de datos fue exitosa
        if ($stmt->affected_rows > 0) {
            $response['mensaje'] = 'Guardado'; // Éxito al guardar
        } else {
            $response['mensaje'] = 'No se guardó'; // Error al guardar
        }
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
