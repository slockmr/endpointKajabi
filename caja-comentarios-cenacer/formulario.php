<?php
// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibe los datos del formulario
    $nombre = $_POST["nombre"];
    $comentario = $_POST["comentario"];
    
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
    $sql = "INSERT INTO Com_CursosAgosto (nombre, comentario) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error en la consulta: " . $conn->error);
    }

    $stmt->bind_param("ss", $nombre, $comentario);

    if ($stmt->execute() === true) {
        echo "Comentario guardado con éxito.";
    } else {
        echo "Error al guardar el comentario: " . $stmt->error;
    }

    // Cerrar la conexión a la base de datos
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Comentarios</title>
</head>
<body>
    <h1>Formulario de Comentarios</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>
        <br>
        <label for="comentario">Comentario:</label>
        <textarea name="comentario" id="comentario" rows="4" required></textarea>
        <br>
        <input type="submit" value="Enviar Comentario">
    </form>
</body>
</html>
