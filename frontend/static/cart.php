<?php
session_start();

$user_logged   = isset($_SESSION['user_id']);
$cart_count    = 0;
$cartItemsData = [];

// total_carrito = importe, total_quantity = nº de entradas
$cartTotals    = [
    'total_carrito'  => 0,
    'total_quantity' => 0,
];

// Conexión a BD (mysqli)
require_once __DIR__ . '/../../backend/config/database.php';

// 1) Datos para usuario logueado
if ($user_logged) {
    require_once __DIR__ . '/../../backend/controllers/cart.php';

    $user_id    = $_SESSION['user_id'];
    $cart_logic = new Cart($conn, $user_id);
    $cart_items = $cart_logic->getCartItems();

    // sumamos todas las cantidades
    $cart_count = array_sum(array_column($cart_items, 'quantity'));

    $total = 0;
    foreach ($cart_items as $item) {
        $evt_id = (int)$item['event_id'];
        // pedimos también event_date
        $sql = "SELECT event_name, price, event_date
                  FROM events
                 WHERE id = $evt_id";
        $res = $conn->query($sql);
        if (! $res || $res->num_rows === 0) {
            continue;
        }
        $event = $res->fetch_assoc();

        $subtotal = $event['price'] * $item['quantity'];
        $total   += $subtotal;

        $cartItemsData[] = [
            'item'     => $item,
            'event'    => $event,
            'subtotal' => $subtotal,
        ];
    }

    $cartTotals['total_carrito']  = $total;
    $cartTotals['total_quantity'] = $cart_count;
}

// 2) Datos de todos los eventos para invitados
$eventsMap = [];
$evRes = $conn->query("
    SELECT id, event_name, price, event_date
      FROM events
");
if ($evRes && $evRes->num_rows > 0) {
    while ($row = $evRes->fetch_assoc()) {
        $eventsMap[$row['id']] = [
            'event_name' => $row['event_name'],
            'price'      => (float)$row['price'],
            'event_date' => $row['event_date'],
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi carrito</title>
    <!-- Bootstrap CSS + Icons + Tu CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="../assets/style/cart.css" rel="stylesheet">
</head>

<body>
    <?php include 'header.php'; ?>

    <main class="d-flex align-items-center justify-content-center font-family_cart mt-5 mb-5 h-75">
        <div class="container row d-flex flex-md-row flex-column">

            <!-- Columna izquierda: Carrito -->
            <div class="col-md-8 ">
                <div class="p-4 d-flex justify-content-md-between">
                    <h2 class="text-left">My cart</h2>
                    <div class="carrito-icono m-2">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge badge-primary"><?= $cart_count ?></span>
                    </div>
                </div>
                <hr style="border: 1px solid #4d194d" />

                <div class="p-5 text-center">

                    <!-- Usuario logeado -->
                    <?php if ($user_logged): ?>
                        <?php if (!empty($cartItemsData)): ?>
                            <ul class="list-unstyled">
                                <?php foreach ($cartItemsData as $data): ?>
                                    <li class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="col-4 d-flex flex-column justify-content-center">
                                            <strong><?= htmlspecialchars($data['event']['event_name']) ?></strong>
                                            <p class="text-muted">
                                                <?= date('d/m/Y', strtotime($data['event']['event_date'])) ?>
                                            </p>
                                        </div>

                                        <div class="col-4 d-flex align-items-center justify-content-between rounded-pill px-3 py-1"
                                            style="background-color: #b44cb4; width: 100px;">
                                            <a class="btn p-0 border-0 text-white d-flex align-items-center justify-content-center"
                                                href="../../backend/controllers/cart.php?id=<?= $data['item']['id'] ?>&quantity=<?= $data['item']['quantity'] ?>&action=decrement"
                                                style="background-color: transparent; width: 20px; height: 20px; font-size: 16px;">
                                                <i class="fas fa-minus"></i>
                                            </a>
                                            <span class="text-white fs-6"><?= $data['item']['quantity'] ?></span>
                                            <a class="btn p-0 border-0 text-white d-flex align-items-center justify-content-center"
                                                href="../../backend/controllers/cart.php?id=<?= $data['item']['id'] ?>&quantity=<?= $data['item']['quantity'] ?>&action=increment"
                                                style="background-color: transparent; width: 20px; height: 20px; font-size: 16px;">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </div>

                                        <div class="col-4">
                                            <?= number_format($data['event']['price'], 2) ?> € x <?= $data['item']['quantity'] ?> =
                                            <strong><?= number_format($data['subtotal'], 2) ?> €</strong>
                                            <a class="ms-4 text-danger"
                                                href="../../backend/controllers/cart.php?id=<?= $data['item']['id'] ?>&action=deleteCart">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <div class="col-12 text-center">
                                <p>Your cart is empty</p>
                            </div>
                            <button class="empty-cart-button">
                                <a href="./catalog-events.php" class="text-white" style="text-decoration: none;">
                                    Find your event here!
                                </a>
                            </button>
                        <?php endif; ?>

                        <!-- Invitado -->
                    <?php else: ?>
                        <ul id="guest-cart-list" class="list-unstyled w-100"></ul>
                        <div id="guest-empty" class="col-12 text-center py-5">
                            <p>Your cart is empty</p>
                            <button class="empty-cart-button">
                                <a href="./catalog-events.php" class="text-white" style="text-decoration: none;">
                                    Find your event here!
                                </a>
                            </button>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Columna derecha: Resumen -->
            <!-- AQUI DEBES OCULTARLO CUANDO SE USUARIO NO LOGEADO -->
            <div class="col-md-4 pt-4">
                <h2 class="text-left mb-5">Total</h2>
                <div class="card p-4" style="padding-bottom: 3px; margin-bottom: 0px;">
                    <h2 class="resumen-pedido">Order Summary</h2>
                    <hr style="margin-top: 0px; border: 1px solid #4d194d;" />
                    <div class="text-center" style="height: 300px; font-size: 12px;">

                        <!-- Resumen usuario logeado -->
                        <?php if ($user_logged && !empty($cartItemsData)): ?>
                            <ul class="list-unstyled">
                                <?php foreach ($cartItemsData as $data): ?>
                                    <li class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex flex-column justify-content-center">
                                            <strong><?= htmlspecialchars($data['event']['event_name']) ?></strong>
                                        </div>
                                        <div><strong><?= number_format($data['subtotal'], 2) ?> €</strong></div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <!-- Resumen invitado -->
                        <?php else: ?>
                            <div id="guest-summary-container">
                                <ul id="guest-summary-list" class="list-unstyled mb-3"></ul>
                                <hr style="border: 1px solid #4d194d" />
                                <div class="d-flex justify-content-between">
                                    <span>Taxes (10%)</span>
                                    <div id="guest-tax">0.00 €</div>
                                </div>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <span>Management</span>
                                    <div id="guest-management">0.00 €</div>
                                </div>
                                <hr style="border: 1px solid #4d194d" />
                                <div class="d-flex justify-content-between flex-wrap">
                                    <strong>Total</strong>
                                    <div><strong id="guest-total">0.00 €</strong></div>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>

                    <hr style="border: 1px solid #4d194d" />

                    <!-- Estas líneas solo para usuario logeado -->
                    <?php if ($user_logged && !empty($cartItemsData)): ?>
                        <div class="d-flex justify-content-between">
                            <span>Taxes</span>
                            <div><?= number_format($cartTotals['total_carrito'] * 0.1, 2) ?> €</div>
                        </div>
                        <div class="d-flex justify-content-between flex-wrap">
                            <span>Management</span>
                            <div><?= number_format($cartTotals['total_quantity'], 2) ?> €</div>
                        </div>
                        <hr style="border: 1px solid #4d194d" />
                        <div class="d-flex justify-content-between flex-wrap">
                            <strong>Total</strong>
                            <div>
                                <strong><?= number_format($cartTotals['total_carrito'] + $cartTotals['total_quantity'], 2) ?> €</strong>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Botón Pay -->
                    <?php if ($user_logged && !empty($cartItemsData)): ?>
                        <div class="d-flex justify-content-center row mb-4 mt-5">
                            <button class="empty-cart-button w-50 p-3" type="submit"
                                onclick="window.location.href='pago.php'">
                                Pay
                            </button>
                        </div>
                    <?php elseif (! $user_logged): ?>
                        <div class="d-flex justify-content-center row mb-4 mt-5" id="guest-pay-button" style="display:none;">
                            <button class="empty-cart-button w-50 p-3" type="submit"
                                onclick="window.location.href='pago.php'">
                                Pay
                            </button>
                        </div>
                    <?php endif; ?>

                </div>
            </div>


        </div>
    </main>

    <?php if (! $user_logged): ?>
        <script>
            const EVENT_DATA = <?= json_encode($eventsMap, JSON_HEX_TAG) ?>;

            (function() {
                const list = document.getElementById('guest-cart-list');
                const empty = document.getElementById('guest-empty');
                const pay = document.getElementById('guest-pay-button');
                const sumList = document.getElementById('guest-summary-list');
                const taxField = document.getElementById('guest-tax');
                const mgmtField = document.getElementById('guest-management');
                const totField = document.getElementById('guest-total');

                // Función para obtener el carrito del localStorage
                const getCartFromLocalStorage = () => JSON.parse(localStorage.getItem('cart')) || [];

                // Función para guardar el carrito en el localStorage y renderizar
                const updateLocalStorageAndRender = (newCart) => {
                    localStorage.setItem('cart', JSON.stringify(newCart));
                    renderGuestCart(newCart);
                };

                const renderGuestCart = (currentCart) => {
                    console.log('renderGuestCart llamada con:', currentCart);
                    list.innerHTML = '';
                    sumList.innerHTML = '';
                    let totalCarrito = 0;
                    let totalQty = 0;

                    if (!currentCart.length) {
                        empty.style.display = 'block';
                        pay.style.display = 'none';
                        taxField.textContent = '0.00 €';
                        mgmtField.textContent = '0.00 €';
                        totField.textContent = '0.00 €';
                        return;
                    }

                    empty.style.display = 'none';
                    pay.style.display = 'inline-block';

                    currentCart.forEach(item => {
                        const info = EVENT_DATA[item.event_id] || { event_name: 'Desconocido', price: 0, event_date: '' };
                        const qty = item.quantity;
                        const subtotal = info.price * qty;
                        totalCarrito += subtotal;
                        totalQty += qty;

                        const li = document.createElement('li');
                        li.className = 'd-flex justify-content-between align-items-center mb-3';
                        li.innerHTML = `
                            <div class="col-4 d-flex flex-column justify-content-center">
                                <strong>${info.event_name}</strong>
                                <p class="text-muted">
                                    ${info.event_date ? new Date(info.event_date).toLocaleDateString('es-ES') : ''}
                                </p>
                            </div>
                            <div class="col-4 d-flex align-items-center justify-content-between rounded-pill px-3 py-1"
                                 style="background-color: #b44cb4; width: 100px;">
                                <button class="btn p-0 border-0 text-white d-flex align-items-center justify-content-center decrement-btn"
                                        data-event-id="${item.event_id}"
                                        style="background-color: transparent; width: 20px; height: 20px; font-size: 16px;">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <span class="text-white fs-6 item-quantity">${qty}</span>
                                <button class="btn p-0 border-0 text-white d-flex align-items-center justify-content-center increment-btn"
                                        data-event-id="${item.event_id}"
                                        style="background-color: transparent; width: 20px; height: 20px; font-size: 16px;">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="col-4">
                                ${info.price.toFixed(2)} € x ${qty} =
                                <strong>${subtotal.toFixed(2)} €</strong>
                                <button class="ms-4 text-danger delete-btn"
                                        data-event-id="${item.event_id}"
                                        style="border: none; background: none; padding: 0;">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>`;
                        list.appendChild(li);

                        const sumLi = document.createElement('li');
                        sumLi.className = 'd-flex justify-content-between align-items-center mb-3';
                        sumLi.innerHTML = `
                            <div class="d-flex flex-column justify-content-center">
                                <strong>${info.event_name}</strong>
                            </div>
                            <div><strong>${subtotal.toFixed(2)} €</strong></div>`;
                        sumList.appendChild(sumLi);
                    });

                    taxField.textContent = (totalCarrito * 0.1).toFixed(2) + ' €';
                    mgmtField.textContent = totalQty.toFixed(2) + ' €';
                    totField.textContent = (totalCarrito + totalQty).toFixed(2) + ' €';
                };

                list.addEventListener('click', function(event) {
                    let targetElement = event.target;
                    const cart = getCartFromLocalStorage();
                
                    while (targetElement && targetElement !== list) {
                        if (targetElement.classList.contains('increment-btn')) {
                            const eventIdToIncrement = parseInt(targetElement.dataset.eventId);
                            const updatedCart = cart.map(item =>
                                parseInt(item.event_id) === eventIdToIncrement ? { ...item, quantity: item.quantity + 1 } : item
                            );
                            updateLocalStorageAndRender(updatedCart);
                            return;
                        } else if (targetElement.classList.contains('decrement-btn')) {
                            const eventIdToDecrement = parseInt(targetElement.dataset.eventId);
                            const updatedCart = cart.map(item =>
                                parseInt(item.event_id) === eventIdToDecrement && item.quantity > 1 ? { ...item, quantity: item.quantity - 1 } : item
                            ).filter(item => item.quantity > 0);
                            updateLocalStorageAndRender(updatedCart);
                            return;
                        } else if (targetElement.classList.contains('delete-btn')) {
                            const eventIdToDelete = parseInt(targetElement.dataset.eventId);
                            const updatedCart = cart.filter(item => parseInt(item.event_id) !== eventIdToDelete);
                            updateLocalStorageAndRender(updatedCart);
                            return;
                        }
                        targetElement = targetElement.parentNode;
                    }
                });
                renderGuestCart(getCartFromLocalStorage());
            })();
        </script>
    <?php endif; ?>

    <?php include '../static/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>