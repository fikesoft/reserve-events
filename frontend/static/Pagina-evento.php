<?php

session_start();
// Conexión a la base de datos
$host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'random_events_db';

$userLogged = isset($_SESSION['user_id']);

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
$conn->set_charset('utf8');

$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$event_id) {
    echo "<p>Evento no especificado. <a href='catalog-events.php'>Volver al listado</a>.</p>";
    exit;
}

// Preparar y ejecutar consulta
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "<p>Evento no encontrado. <a href='catalog-events.php'>Volver al listado</a>.</p>";
    exit;
}
$event = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($event['event_name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style/header.css">
    <link rel="stylesheet" href="../assets/style/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <!-- Header -->
    <?php include 'header.php'; ?>

    <main class="container-fluid my-5 px-3 px-md-5 flex-fill">
        <div class="row">
            <div class="col-12 col-md-5 d-flex justify-content-center align-items-center mb-3 mb-md-0">
                <img src="<?= htmlspecialchars($event['image_url']); ?>" class="img-fluid" style="max-height: 300px; object-fit: cover;" alt="<?= htmlspecialchars($event['event_name']); ?>">
            </div>
            <div class="col-12 col-md-7 align-content-center">
                <div class="d-flex flex-column flex-md-row align-items-stretch border rounded overflow-hidden">
                    <div class="text-white text-center p-4 d-flex flex-column justify-content-center rounded-start" style="background-color:#4d194d; min-width:120px;">
                        <p class="mb-2 fw-bold"><?= date('d', strtotime($event['event_date'])); ?></p>
                        <p class="mb-2"><?= strtoupper(date('D', strtotime($event['event_date']))); ?></p>
                        <p class="mb-0"><?= date('H:i', strtotime($event['event_time'])); ?></p>
                    </div>

                    <div class="ms-md-3 mt-3 mt-md-0 w-100 d-flex flex-column justify-content-around">
                        <div class="d-flex flex-column mb-2">
                            <p class="fw-bold mb-1 text-center text-md-start"><?= htmlspecialchars($event['event_name']); ?></p>
                        </div>
                        <div class="d-flex flex-column flex-md-row justify-content-between text-center text-md-start gap-3">
                            <div class="d-flex flex-column align-items-center align-items-md-start">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-map-location"></i>
                                    <p class="mb-1 fw-bold" style="color: #4d194d;"><?= htmlspecialchars($event['location']); ?></p>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fa-solid fa-city"></i>
                                    <p class="mb-1 fw-bold" style="color: #4d194d;"><?= htmlspecialchars($event['city']); ?></p>
                                </div>
                            </div>
                            <div class="d-flex flex-column align-items-center gap-2 mx-2">
                                <p class="mb-0"><?= number_format($event['price'], 2); ?> € / person</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <p><?= nl2br(htmlspecialchars($event['description'])); ?></p>
                </div>
                <!-- AQUI BUTTON -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="catalog-events.php" class="btn btn-outline-dark">Volver</a>
                    <form id="addToCartForm"
                        action="../../backend/controllers/cart.php"
                        method="POST"
                        class="d-inline">
                        <input type="hidden" name="action" value="addToCart">
                        <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                        <input type="hidden" name="quantity" id="quantityInput" value="1">
                        <button type="submit" class="btn text-white" style="background-color: #4d194d;">
                            Añadir al carrito
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include 'footer.php'; ?>

    <script>
        // Actualizar el valor del input oculto al cambiar la cantidad
        document.getElementById('increase').addEventListener('click', function() {
            let quantity = document.getElementById('quantity');
            document.getElementById('quantityInput').value = parseInt(quantity.textContent);
        });

        document.getElementById('decrease').addEventListener('click', function() {
            let quantity = document.getElementById('quantity');
            document.getElementById('quantityInput').value = parseInt(quantity.textContent);
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Convertimos el flag PHP a JS
        const userLogged = <?= $userLogged ? 'true' : 'false' ?>;
        const form = document.getElementById('addToCartForm');

        form.addEventListener('submit', function(e) {
            // Si NO está logueado, guardamos en localStorage
            if (!userLogged) {
                e.preventDefault();

                const eventId = form.querySelector('input[name="event_id"]').value;
                const quantity = parseInt(
                    form.querySelector('input[name="quantity"]').value, 10
                );

                // Cargo carrito actual o inicializo vacío
                let cart = JSON.parse(localStorage.getItem('cart')) || [];

                // Busco si ya existe este evento
                const idx = cart.findIndex(item => item.event_id === eventId);
                if (idx > -1) {
                    // Si existe, sumo cantidades
                    cart[idx].quantity += quantity;
                } else {
                    // Si no existe, lo añado
                    cart.push({
                        event_id: eventId,
                        quantity
                    });
                }

                // Guardo de nuevo
                localStorage.setItem('cart', JSON.stringify(cart));
                alert('✓ Producto añadido al carrito local.');
            }
            // Si está logueado, deja que el form se envíe normalmente
        });
    </script>
</body>

</html>