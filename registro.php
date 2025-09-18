<?php
// registro.php: Procesa el registro de usuario y redirige a login
ob_start();
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'FitConnet';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';
    $id_objetivo = isset($_POST['id_objetivo']) ? intval($_POST['id_objetivo']) : 1;

    // Hashear la contraseña antes de guardar
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    // Verifica que el correo no exista ya
    $stmt = $conn->prepare('SELECT * FROM usuarios WHERE correo_electronico = ?');
    $stmt->bind_param('s', $correo);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo '<script>alert("El correo ya está registrado."); window.location.href = "registro/registro.html";</script>';
        ob_end_flush();
        exit();
    }
    $stmt->close();

    // Inserta el usuario
    $stmt = $conn->prepare('INSERT INTO usuarios (nombre, correo_electronico, contrasena, id_objetivo) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('sssi', $nombre, $correo, $contrasena_hash, $id_objetivo);
    if ($stmt->execute()) {
        // Verifica si se insertó al menos una fila
        if ($stmt->affected_rows > 0) {
            // Registro exitoso, redirige a index o login
            echo '<script>alert("Registro exitoso. Inicia sesión."); window.location.href = "index/index.html";</script>';
        } else {
            echo '<script>alert("No se pudo insertar el usuario. Verifica los datos."); window.location.href = "registro/registro.html";</script>';
        }
    } else {
        $errorMsg = addslashes($stmt->error);
        echo "<script>alert('Error al registrar usuario: $errorMsg'); window.location.href = 'registro/registro.html';</script>";
    }
    $stmt->close();
}
$conn->close();
ob_end_flush();
?>
