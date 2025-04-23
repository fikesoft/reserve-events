<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../config/database.php';
require_once '../controllers/cart.php';

$userId = $_SESSION['user_id'];
$eventId = $_POST['event_id'] ?? 0;
$quantity = $_POST['quantity'] ?? 1;

$cart = new Cart($conn, $userId);

// Verificar si el evento ya está en el carrito
$existingItem = $cart->getCartItemByEventId($eventId);
if ($existingItem) {
    $newQuantity = $existingItem['quantity'] + $quantity;
    $cart->updateCartItemQuantity($existingItem['id'], $newQuantity);
} else {
    $cart->addToCart($eventId, $quantity);
}

$_SESSION['message'] = 'Evento añadido al carrito';
header("Location: ../../frontend/static/pagina-evento.php?id={$eventId}");
exit();
