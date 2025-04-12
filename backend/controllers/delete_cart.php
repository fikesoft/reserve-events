<?php

session_start();

$product_cart_id = (int)$_GET['id']; // Ensure the ID is an integer

// Include the database connection
require '../config/database.php';

// Delete the event in cart from the database
try {
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $product_cart_id); // Bind the event ID as an integer
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = 'Producto del carrito eliminado con éxito';
    } else {
        $_SESSION['error'] = 'No se encontró el producto en el carrito para eliminar.';
    }

    $stmt->close(); // Close the prepared statement
} catch (Exception $e) {
    $_SESSION['error'] = 'Error al eliminar el producto del carrito: ' . $e->getMessage();
}

// Redirect back to the cart page
header('Location: ../../frontend/static/cart.php');
exit();
?>