<?php
session_start();
require_once '../config/database.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if( empty($email) || empty($password)){
    $_SESSION['error'] = "Email y contraseña son obligatorios";
    $_SESSION['form_data'] = ['email' => $email];
    header("Location: ../../frontend/static/login.php");
    exit();
}

//Buscar si esta en la base de datos
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if(!$user || !password_verify($password, $user['password'])){
    $_SESSION['error'] = "Email o contraseña incorrectos";
    $_SESSION['form_data'] = ['email' => $email];
    header("Location: ../../frontend/static/login.php");
    exit();
}

//Inicio de sesion correcto

$_SESSION['user_id'] = $user['user_id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['user_role'] = $user['role'];
$_SESSION['success'] = "¡Bienvenido, " . $user['name'] . "!";

//regenerar el id de la sesion por seguridad
session_regenerate_id();

header("Location: ../../frontend/static/home.php");
exit();

?>