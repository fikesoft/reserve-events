<?php

session_start();

// Redirect if the user is not an admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../../frontend/static/login.php');
    exit();
}

// Validate and sanitize the event ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: ../../frontend/static/home.php'); // Redirect if no ID is provided
    exit();
}

$event_id = (int)$_GET['id']; // Ensure the ID is an integer

// Include the database connection
require '../config/database.php';

// Delete the event from the database
try {
    $stmt = $conn->prepare("DELETE FROM events WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $event_id); // Bind the event ID as an integer
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = 'Evento eliminado con éxito';
    } else {
        $_SESSION['error'] = 'No se encontró el evento para eliminar.';
    }

    $stmt->close(); // Close the prepared statement
} catch (Exception $e) {
    $_SESSION['error'] = 'Error al eliminar el evento: ' . $e->getMessage();
}

// Redirect back to the events page
header('Location: ../../frontend/static/home.php');
exit();
?>