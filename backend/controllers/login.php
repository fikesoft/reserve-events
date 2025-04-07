<?php
session_start();
require_once '../config/database.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Validación básica
if (empty($email) || empty($password)) {
    $_SESSION['error'] = "Email y contraseña son obligatorios";
    $_SESSION['form_data'] = ['email' => $email];
    header("Location: ../../frontend/static/login.php");
    exit();
}

// Buscar si el usuario existe en la base de datos
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Verificar si el usuario existe y si la contraseña es correcta
if (!$user || !password_verify($password, $user['password'])) {
    $_SESSION['error'] = "Email o contraseña incorrectos";
    $_SESSION['form_data'] = ['email' => $email];
    header("Location: ../../frontend/static/login.php");
    exit();
}

// Inicio de sesión correcto
$_SESSION['user_id'] = $user['id']; // Corregido: Usar 'id' en lugar de 'user_id'
$_SESSION['user_name'] = $user['name'];
$_SESSION['user_role'] = $user['role'];
$_SESSION['success'] = "¡Bienvenido, " . $user['name'] . "!";

// Regenerar el ID de la sesión por seguridad
session_regenerate_id();

header("Location: ../../frontend/static/home.php");
exit();
?>