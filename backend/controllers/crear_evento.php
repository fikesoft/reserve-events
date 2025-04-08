<?php
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../../frontend/static/login.php');
    exit();
}

// Recoger datos del formulario
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$eventName = $_POST['eventName'] ?? '';
$description = $_POST['description'] ?? '';
$date = $_POST['date'] ?? '';
$time = $_POST['time'] ?? '';
$image = $_POST['image'] ?? '';
$location = $_POST['location'] ?? '';
$price = $_POST['price'] ?? 0;
$ticketTypes = $_POST['ticket-types'] ?? [];
$numberTickets = $_POST['number_tickets'] ?? 0;

// Validar datos
if (empty($name) || empty($email) || empty($eventName) || empty($date) || empty($time) || empty($image) || empty($location) || empty($numberTickets)) {
    die("Todos los campos son obligatorios.");
}

// Convertir los tipos de boletos en una cadena separada por comas
$ticketTypesStr = implode(',', $ticketTypes);

// Preparar la consulta SQL
$sql = "INSERT INTO events (
    name, email, event_name, description, event_date, event_time, image_url, 
    location,
     price,
     ticket_type, 
    number_of_tickets
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssssdsi",
    $name,
    $email,
    $eventName,
    $description,
    $date,
    $time,
    $image,
    $location,
    $price,
    $ticketTypesStr,
    $numberTickets
);

// Ejecutar la consulta
if ($stmt->execute()) {
    // Redirigir con éxito
    header("Location: ../../frontend/static/home.php?success=true");
    exit();
} else {
    // Mostrar error
    die("Error al registrar el evento: " . $stmt->error);
}
?>