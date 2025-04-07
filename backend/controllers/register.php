<?php
session_start();
// Incluir la conexión a la base de datos
require_once '../config/database.php';

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';


//Validacion
if (empty($name)  ||empty($email) || empty($password)) {
    $_SESSION['error'] = "Todos los campos son obligatorios";
    $_SESSION['form_data'] = $_POST; // Guardar datos ingresados
    header("Location: ../../frontend/static/register.php");
    exit();
}


if ($password !== $confirm_password) {
    $_SESSION['error'] = "Las contraseñas no coinciden";
    $_SESSION['form_data'] = $_POST;
    header("Location: ../../frontend/static/register.php");
    exit();
}

// Verificar si el email ya existe
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['error'] = "El email ya está registrado";
    $_SESSION['form_data'] = $_POST;
    header("Location: ../../frontend/static/register.php");
    exit();
}

// Hash de la contraseña
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insertar usuario en la base de datos
$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $hashed_password);

if ($stmt->execute()) {
    $_SESSION['success'] ="¡Registro exitoso!";
    header("Location: ../../frontend/static/login.php");
    exit();
} else {
    $_SESSION['error'] ="Error: " . $stmt->error;
    header("Location: ../../frontend/static/register.php");
    exit();
}

$stmt->close();
$conn->close();
?>