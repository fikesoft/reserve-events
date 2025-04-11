<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../../frontend/static/home.php');
    exit;
}

require_once '../config/database.php';

if (!isset($_GET['id'])) {
    header('Location: ../../frontend/static/home.php');
    exit;
}

$eventId = $_GET['id'];
$sql = "SELECT * FROM events WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $eventId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: ../../frontend/static/home.php');
    exit;
}

$event = $result->fetch_assoc();
$_SESSION['edit_event'] = $event;
header('Location: ../../frontend/static/add_your_event.php?edit=' . $eventId);
exit;
?>