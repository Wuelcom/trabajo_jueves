<?php
ob_start(); // Iniciar buffer de salida para evitar problemas con header()
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'FitConnet';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    // Buscar usuario por nombre o correo
    $stmt = $conn->prepare('SELECT * FROM usuarios WHERE nombre = ? OR correo_electronico = ?');
    $stmt->bind_param('ss', $usuario, $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($contrasena, $user['contrasena'])) {
            // Login exitoso, redirige a index
            header('Location: index/index.html');
            ob_end_flush();
            exit();
        }
    }
    // Login fallido, muestra mensaje y regresa a login
    echo '<script>alert("Usuario, correo o contraseña incorrectos. Por favor, inténtalo de nuevo."); window.location.href = "login.html";</script>';
    ob_end_flush();
    exit();
}
$conn->close();
