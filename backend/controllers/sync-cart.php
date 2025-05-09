<?php
session_start();
header('Content-Type: application/json');

// 1. Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

require_once '../../backend/config/database.php';
require_once 'cart.php';         // your Cart class
require_once 'init.php';         // if you need session/db init here

$userId   = $_SESSION['user_id'];
$cartLogic = new Cart($conn, $userId);

// 2. Parse incoming JSON
$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!isset($data['cart']) || !is_array($data['cart'])) {
    echo json_encode(['success' => false, 'message' => 'Bad payload']);
    exit();
}

// 3. Insert each guest item
foreach ($data['cart'] as $item) {
    $evtId = (int)($item['event_id'] ?? 0);
    $qty   = (int)($item['quantity'] ?? 0);
    if ($evtId > 0 && $qty > 0) {

        $existingItem = $cartLogic->getCartItemByEventId($evtId);
        if ($existingItem) {
            $newQuantity = $existingItem['quantity'] + $qty;
            $cartLogic->updateCartItemQuantity($existingItem['id'], $newQuantity);
        } else {
            $cartLogic->addToCart($evtId, $qty);
        }
    }
}

// 4. Return JSON
echo json_encode(['success' => true, 'message' => 'Cart synced']);
