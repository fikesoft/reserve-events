<?php

session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../../frontend/static/login.php');
    exit();
}
// Obtener ID del evento a eliminar
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location:../../frontend/static/home.php'); // Redirigir si no hay ID
    exit();
}

$event_id = (int)$_GET['id']; 


require '../config/database.php'; 

// Eliminar el evento de la base de datos
try {
    $stmt = $pdo->prepare("DELETE FROM events WHERE id = ? LIMIT 1");
    $stmt->execute([$event_id]);
    
    // Opcional: Eliminar también la imagen asociada del servidor
    // if ($event['image_url']) unlink($event['image_url']);
    
    $_SESSION['message'] = 'Evento eliminado con éxito';
} catch (Exception $e) {
    $_SESSION['error'] = 'Error al eliminar el evento: ' . $e->getMessage();
}

// Redirigir a la página de eventos
header('Location: events.php');
exit();
?>