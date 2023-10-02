<?php
// Verifica si se ha recibido una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos enviados en formato JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Extrae los campos de nombre y comentario
    $nombre = $data["nombre"];
    $comentario = $data["comentario"];

    // Conexión a la base de datos MySQL
    $servername = "localhost";
    $username = "id21302362_admin";
    $password = "Cenacer1.";
    $dbname = "id21302362_cursosagosto";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Preparar la consulta SQL para insertar el comentario
    $sql = "INSERT INTO Comentarios (nombre, comentario) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error en la consulta: " . $conn->error);
    }

    $stmt->bind_param("ss", $nombre, $comentario);

    if ($stmt->execute() === true) {
        // Comentario guardado con éxito
        $response = ["mensaje" => "Comentario guardado con éxito"];
        http_response_code(200); // OK

        // Envía un mensaje de confirmación por consola
        error_log("Solicitud POST recibida: Comentario guardado con éxito");
    } else {
        // Error al guardar el comentario
        $response = ["error" => "Error al guardar el comentario"];
        http_response_code(500); // Error interno del servidor

        // Envía un mensaje de error por consola
        error_log("Solicitud POST recibida: Error al guardar el comentario");
    }

    // Enviar una respuesta en formato JSON
    header("Content-Type: application/json");
    echo json_encode($response);

    // Cerrar la conexión a la base de datos
    $stmt->close();
    $conn->close();
} else {
    // Manejar otros métodos HTTP o mostrar un error si es necesario
    http_response_code(405); // Método no permitido
    echo json_encode(["error" => "Método no permitido"]);
}
?>

