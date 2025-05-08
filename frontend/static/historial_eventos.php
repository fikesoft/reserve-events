<?php

session_start();
echo 'Usuario logueado con ID: ' . ($_SESSION['user_id'] ?? 'NO DEFINIDO');

// Verificar que el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    die("Error: el usuario no ha iniciado sesión.");
}

$user_id = $_SESSION['user_id'];

// Conexión a la base de datos
include __DIR__ . '/../../backend/controllers/connection.php';

// Verificar que $user_id sea un entero
$user_id = (int) $user_id;
var_dump($user_id); // Verifica que sea un número entero

// Obtener el total de pedidos
$sql_total = "SELECT COUNT(*) AS total FROM orders WHERE user_id = ?";
$stmt_total = $conn->prepare($sql_total);
$stmt_total->bind_param("i", $user_id);
$stmt_total->execute();
$result_total = $stmt_total->get_result();
$row_total = $result_total->fetch_assoc();
$total_pedidos = $row_total['total'];

// Mostrar el total de pedidos para depuración
echo 'Total de pedidos: ' . $total_pedidos;

// Obtener detalles de pedidos y eventos con el JOIN

// Obtener detalles de pedidos y eventos con el JOIN
$sql = "
    SELECT 
        orders.id AS order_id,
        orders.order_date,
        orders.total,
        orders.payment_method,
        orders.city AS user_city,
        orders.province,
        orders.country,
        orders.zip_code,
        order_detail.quantity,
        order_detail.unit_price,
        events.name,
        events.event_name,
        events.event_date,
        events.city AS event_city,
        events.location,
        events.style,
        events.image_url
    FROM orders
    JOIN order_detail ON orders.id = order_detail.order_id
    JOIN events ON order_detail.event_id = events.id
    WHERE orders.user_id = ?
    ORDER BY orders.order_date DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial eventos</title>
    <!-- Cargar Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/style/style-historial.css">
    <!-- Cargar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <header>
        <!-- Encabezado -->
        <?php
        include "../static/header.php";
        ?>
    </header>
    <main>
        <div class="container mt-5 mb-5">
            <div class="row">
                <h1>Historial de eventos</h1>
            </div>
            <div class="row">
                <?php if (count($data) > 0): ?>

                <div class="d-flex">
                    <h6 class="me-2"><strong class="me-2"><?= $total_pedidos ?></strong> pedidos realizados en: </h6>
                    <form action="#">
                        <select name="tiempo" id="time">
                            <option value="1 semana"> 1 semana</option>
                        </select>
                    </form>
                </div>

                <?php foreach ($data as $row): ?>
                <div class="row border border-2 border-grey rounded-3 p-3 mt-3">
                    <div class="row border-bottom border-2 border-grey mb-3 ms-1 me-1">
                        <div class="col">
                            <div>
                                <h6>PEDIDO REALIZADO: </h6>
                                <p><?= date('d/m/Y H:i', strtotime($row['order_date'])) ?></p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="">
                                <h6>PRECIO TOTAL: </h6>
                                <p><?= number_format($row['total'], 2) ?>€</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="d-flex text-center justify-content-center mt-3">
                                <h6 class="me-2">Pedido número: </h6>
                                <p><?= $row['order_id'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-5 justify-content-center">
                            <div class="d-flex text-start mt-3">
                                <div>
                                    <h6 class="ms-2"><?= htmlspecialchars($row['event_name']) ?></h6>
                                    <?php
                                    $image_url = $row['image_url'];
                                    if (!file_exists($image_url)) {
                                        echo "<p>⚠ Imagen no encontrada en: $image_url</p>";
                                    }
                                    ?>
                                    <img src="<?= htmlspecialchars($image_url) ?>" alt="imagen evento" class="img-fluid w-50">

                                </div>
                                <div>
                                    <p><strong>Artista: </strong><?= htmlspecialchars($row['name']) ?></p>
                                    <p><strong>Fecha del evento: </strong><?= htmlspecialchars($row['event_date']) ?></p>
                                    <p><strong>Lugar del evento: </strong><?= htmlspecialchars($row['event_city']) ?> (<?= htmlspecialchars($row['location']) ?> )</p>
                                    <p><strong>Estilo del evento: </strong><?= htmlspecialchars($row['style']) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="mt-3 text-center">
                                <p><?= htmlspecialchars($row['user_city']) ?>, <?= htmlspecialchars($row['province']) ?>, <?= htmlspecialchars($row['country']) ?></p>
                                <p>(<?= htmlspecialchars($row['zip_code']) ?>)</p>
                                <p><strong>Método de pago: </strong><?= htmlspecialchars($row['payment_method']) ?></p>
                                <p><strong>Precio por entrada: </strong><?= number_format($row['unit_price'], 2) ?></p>
                            </div>
                        </div>
                        <div class="col-2 d-flex flex-column justify-content-end mt-5 text-end">
                            <div class="">
                                <button>Buscar eventos</button>
                                <p><strong>Cantidad: </strong><?= $row['quantity'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                    <p>No has realizado ningún pedido aún.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer>
        <!-- Footer -->
        <?php
        include '../static/footer.php';
        ?>
    </footer>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
