<?php
session_start();
include '../../backend/config/database.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT 
            o.id AS order_id,
            o.order_date,
            o.total,
            e.event_name,
            e.event_date,
            e.event_time,
            e.city,
            e.location,
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
    <!-- CSS  -->
    <link rel="stylesheet" href="../assets/style/historialPedidos.css">
    <!-- Importar Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Encabezado -->
    <?php
    include "../static/header.php";
    ?>

    <main class="container my-5 font-family_historialPedidos">
        <div class="container my-5">
            <h2 class="mb-4">My Orders</h2>

            <?php if (empty($pedidos)): ?>
                <p class="alert alert-warning text-center py-4 fs-5">
                    You haven't placed any order yet
                </p>
                <img src='/frontend/assets/img/searchEmpty.png' alt='Imagen de historial vacío' class='img-fluid mx-auto d-block mt-3 w-25'>";
            <?php else: ?>
                <?php
                $current_order = 0;
                foreach ($pedidos as $index => $pedido):
                    $is_new_order = $current_order != $pedido['order_id'];
                
                    // Si es un nuevo pedido, cerramos el anterior (si no es el primero)
                    if ($is_new_order):
                        if ($current_order != 0): 
                            echo "</tbody></table></div></div>";
                        endif;
                
                        // Actualizamos ID de pedido actual
                        $current_order = $pedido['order_id'];
                ?>
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Order #<?= $pedido['order_id'] ?></h5>
                            <p class="card-subtitle mb-2 text-muted">
                                <?= date('d/m/Y H:i', strtotime($pedido['order_date'])) ?>h
                                <p><strong>Total:</strong> <?= number_format($pedido['total'], 2) ?> €</p>
                            </p>
                            <table class="table table-bordered table-hover mt-3">
                                <thead class="table-light">
                                    <tr>
                                        <th>Event</th>
                                        <th>Event Date</th>
                                        <th>Event Time</th>
                                        <th>Location</th>
                                        <th>City</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                    <?php endif; ?>
                            <tr>
                                <td><?= $pedido['event_name'] ?></td>
                                <td><?= date('d/m/Y', strtotime($pedido['event_date'])) ?></td>
                                <td><?= date('H:i', strtotime($pedido['event_time'])) ?>h</td>
                                <td><?= $pedido['location'] ?></td>
                                <td><?= $pedido['city'] ?></td>
                                <td><?= $pedido['quantity'] ?></td>
                                <td><?= number_format($pedido['unit_price'], 2) ?> €</td>
                            </tr>
                <?php
                endforeach;
                echo "</tbody></table></div></div>";
                ?>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <?php
    include '../static/footer.php';
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

