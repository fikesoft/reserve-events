<?php

class Cart
{
    private $conn;
    private $userId;

    public function __construct($conn, $userId)
    {
        $this->conn = $conn;
        $this->userId = $userId;
    }

    public function getCartItems()
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM cart WHERE user_id = ?");
            $stmt->bind_param("i", $this->userId);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public function getEventDetails($eventId)
    {
        $sqlEvt = "SELECT * FROM events WHERE id = {$eventId}";
        $resultEvt = $this->conn->query($sqlEvt);
        return $resultEvt->fetch_assoc();
    }

    public function calculateCartTotals($cartItems)
    {
        $total_carrito = 0;
        $total_quantity = 0;

        foreach ($cartItems as $item) {
            $event = $this->getEventDetails($item['event_id']);
            if ($event) {
                $subtotal = $event['price'] * $item['quantity'];
                $total_carrito += $subtotal;
                $total_quantity += $item['quantity'];
            }
        }

        return [
            'total_carrito' => $total_carrito,
            'total_quantity' => $total_quantity,
        ];
    }

    public function getCartItemsData($cartItems)
    {
        $itemsData = [];
        foreach ($cartItems as $item) {
            $event = $this->getEventDetails($item['event_id']);
            if ($event) {
                $itemsData[] = [
                    'item' => $item,
                    'event' => $event,
                    'subtotal' => $event['price'] * $item['quantity'],
                ];
            }
        }
        return $itemsData;
    }
    public function addToCart($eventId, $quantity)
    {
        $stmt = $this->conn->prepare("INSERT INTO cart (user_id, event_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $this->userId, $eventId, $quantity);
        return $stmt->execute();
    }

    public function getCartItemByEventId($eventId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM cart WHERE user_id = ? AND event_id = ?");
        $stmt->bind_param("ii", $this->userId, $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateCartItemQuantity($cartItemId, $quantity)
    {
        $stmt = $this->conn->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
        $stmt->bind_param("ii", $quantity, $cartItemId);
        return $stmt->execute();
    }

    public function deleteCart($product_cart_id)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM cart WHERE id = ? LIMIT 1");
            $stmt->bind_param("i", $product_cart_id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $_SESSION['message'] = 'Producto del carrito eliminado con éxito';
            } else {
                $_SESSION['error'] = 'No se encontró el producto en el carrito para eliminar.';
            }

            $stmt->close();
        } catch (Exception $e) {
            $_SESSION['error'] = 'Error al eliminar el producto del carrito: ' . $e->getMessage();
        }
    }
}

require_once 'init.php';
require_once '../../backend/config/database.php';

// Asegúrate de que el user_id esté en la sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../frontend/static/login.php"); // Ajusta la ruta si es necesario
    exit();
}

$userId = $_SESSION['user_id'];
$cartLogic = new Cart($conn, $userId);

// **Manejar diferentes acciones según el parámetro 'action'**
if (isset($_POST['action']) && $_POST['action'] === 'addToCart') {
    $eventId = $_POST['event_id'] ?? 0;
    $quantity = $_POST['quantity'] ?? 1;

    // Verificar si el evento ya está en el carrito
    $existingItem = $cartLogic->getCartItemByEventId($eventId);
    if ($existingItem) {
        $newQuantity = $existingItem['quantity'] + $quantity;
        $cartLogic->updateCartItemQuantity($existingItem['id'], $newQuantity);
    } else {
        $cartLogic->addToCart($eventId, $quantity);
    }

    $_SESSION['message'] = 'Evento añadido al carrito';
    header("Location: ../../frontend/static/pagina-evento.php?id={$eventId}");
    exit();
} elseif (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action === 'deleteCart' && isset($_GET['id'])) {
        $itemIdToDelete = (int)$_GET['id'];
        $cartLogic->deleteCart($itemIdToDelete);
        header('Location: ../../frontend/static/cart.php');
        exit();
    } elseif ($action === 'increment' && isset($_GET['id']) && isset($_GET['quantity'])) {
        $itemIdToUpdate = (int)$_GET['id'];
        $currentQuantity = (int)$_GET['quantity'];
        $newQuantity = $currentQuantity + 1;
        $cartLogic->updateCartItemQuantity($itemIdToUpdate, $newQuantity);
        header('Location: ../../frontend/static/cart.php');
        exit();
    } elseif ($action === 'decrement' && isset($_GET['id']) && isset($_GET['quantity'])) {
        $itemIdToUpdate = (int)$_GET['id'];
        $currentQuantity = (int)$_GET['quantity'];
        if ($currentQuantity > 1) {
            $newQuantity = $currentQuantity - 1;
            $cartLogic->updateCartItemQuantity($itemIdToUpdate, $newQuantity);
        }
        header('Location: ../../frontend/static/cart.php');
        exit();
    }
}
