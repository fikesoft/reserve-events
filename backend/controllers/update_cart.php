<?php

session_start();

$product_cart_id = (int)$_GET['id']; // Ensure the ID is an integer
$action = ($_GET['action']);
$quantity = ($_GET['quantity']);

// Include the database connection
require '../config/database.php';

// Delete the event in cart from the database
try {

    if ($action === 'increment') {
        $quantity++;
    } elseif ($action === 'decrement' && $quantity > 1) {
        $quantity--;
    }

    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE id = ? LIMIT 1");
    $stmt->bind_param("ii", $quantity, $product_cart_id); // Bind the event ID as an integer
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = 'Producto del carrito actualizado con éxito';
    } else {
        $_SESSION['error'] = 'No se encontró el producto en el carrito para actualizar.';
    }

    $stmt->close(); // Close the prepared statement
} catch (Exception $e) {
    $_SESSION['error'] = 'Error al actualizar el producto del carrito: ' . $e->getMessage();
}

// Redirect back to the cart page
header('Location: ../../frontend/static/cart.php');
exit();
?>