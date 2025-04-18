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
}
