<?php
session_start();
// Incluir la conexión a la base de datos
require_once '../config/database.php';

// Recuperar los datos del formulario
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Validación básica
if (empty($name) || empty($email) || empty($password)) {
    $_SESSION['error'] = "Todos los campos son obligatorios";
    $_SESSION['form_data'] = $_POST; // Guardar datos ingresados
    header("Location: ../../frontend/static/registeer.php");
    exit();
}

// Verificar si las contraseñas coinciden
if ($password !== $confirm_password) {
    $_SESSION['error'] = "Las contraseñas no coinciden";
    $_SESSION['form_data'] = $_POST;
    header("Location: ../../frontend/static/registeer.php");
    exit();
}

// Verificar si el email ya está registrado
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['error'] = "El email ya está registrado";
    $_SESSION['form_data'] = $_POST;
    header("Location: ../../frontend/static/registeer.php");
    exit();
}

// Comprobar si es el primer usuario
$is_first_user = false;
$stmt = $conn->prepare("SELECT COUNT(*) AS user_count FROM users");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['user_count'] === 0) {
    $is_first_user = true; // Es el primer usuario
}

// Hash de la contraseña
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Asignar rol según si es el primer usuario o no
$role = $is_first_user ? 'admin' : 'user'; // 'admin' para el primer usuario, 'user' para los demás

// Insertar usuario en la base de datos
$stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $hashed_password, $role);

if ($stmt->execute()) {
    if ($is_first_user) {
        $_SESSION['success'] = "¡Registro exitoso! Eres el primer usuario y tienes el rol de administrador.";
    } else {
        $_SESSION['success'] = "¡Registro exitoso!";
    }
    header("Location: ../../frontend/static/login.php");
    exit();
} else {
    $_SESSION['error'] = "Error: " . $stmt->error;
    header("Location: ../../frontend/static/registeer.php");
    exit();
}

// Cerrar recursos
$stmt->close();
$conn->close();
?>