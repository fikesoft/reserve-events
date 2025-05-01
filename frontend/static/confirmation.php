<?php
session_start();
if (!isset($_SESSION['order_id'])) {
    header("Location: cart.php");
    exit();
}

$orderId = $_SESSION['order_id'];
unset($_SESSION['order_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/style/confirmation.css">
</head>
<body>
    <!-- Encabezado -->
    <?php
    include "../static/header.php";
    ?>

    <main class="d-flex align-items-center justify-content-center font-family_cart mt-5 mb-5 h-100">
        <div class="container p-4">
            <div class="confirmation-box bg-light p-5 rounded shadow">
                <div class="text-center">
                    <i class="fas fa-check-circle text-success fa-4x mb-3"></i>
                    <h2>Order Placed Successfully!</h2>
                    <p class="lead">Thank you for your order. Your order number is:</p>
                    <h3 class="order-id mb-4"><?php echo htmlspecialchars($orderId); ?></h3>
                    <p class="mb-4">We will send you an email with your order details shortly.</p>
                    <!-- Botón para descargar el PDF -->
                    <?php
                        $ticketPath = './tickets/ticket_' . $orderId . '.pdf';
                        if (file_exists($ticketPath)) {
                            echo '<div>';
                            echo '<a href="' . htmlspecialchars($ticketPath) . '" download class="btn btn-primary btn-lg return-home-button mb-3">';
                            echo 'Download Ticket';
                            echo '</a>';
                            echo '</div>';
                        } else {
                            echo '<p class="text-danger text-center">El ticket no está disponible aún.</p>';
                        }
                    ?>
                    <a href="home.php" class="btn btn-primary btn-lg return-home-button">Return to Homepage</a>
                    
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php
    include '../static/footer.php';
    ?>
</body>
</html>