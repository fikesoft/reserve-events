<?php
session_start();
include '../../backend/config/database.php';

if (!isset($_SESSION['user_id'])) {
    echo 
        "<div class='alert alert-warning text-center m-4 font-family_buscador'>
            You must log in to view your history orders.
        </div>";
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT 
            o.id AS order_id,
            o.order_date,
            o.total,
            e.event_name,
            e.event_date,
            e.city,
            od.quantity,
            od.unit_price
        FROM orders o
        JOIN order_detail od ON o.id = od.order_id
        JOIN events e ON od.event_id = e.id
        WHERE o.user_id = ?
        ORDER BY o.order_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$pedidos = [];
while ($row = $result->fetch_assoc()) {
    $pedidos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <!-- Encabezado -->
    <?php
    include "../static/header.php";
    ?>

    <main class="m-4">
    <h2>My Orders</h2>

    <?php if (empty($pedidos)): ?>
        <p class="vh-100">No has realizado ningún pedido.</p>
    <?php else: ?>
        <?php
        $current_order = 0;
        foreach ($pedidos as $pedido):
            if ($current_order != $pedido['order_id']):
                if ($current_order != 0) echo "</table><hr>";
                $current_order = $pedido['order_id'];
        ?>
            <h5>Order #<?= $pedido['order_id'] ?></h5>
            <h5><?= $pedido['order_date'] ?></h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Date</th>
                        <th>City</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                    </tr>
                </thead>
                <tbody>
        <?php endif; ?>
                    <tr>
                        <td><?= $pedido['event_name'] ?></td>
                        <td><?= $pedido['event_date'] ?></td>
                        <td><?= $pedido['city'] ?></td>
                        <td><?= $pedido['quantity'] ?></td>
                        <td><?= number_format($pedido['unit_price'], 2) ?> €</td>
                    </tr>
        <?php
        endforeach;
        echo "</tbody></table><hr>";
        ?>
    <?php endif; ?>
    </main>

    <!-- Footer -->
    <?php
    include '../static/footer.php';
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

