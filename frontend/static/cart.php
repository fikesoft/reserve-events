<?php
require_once '../../backend/config/database.php';
require_once '../../backend/controllers/cart.php';
require_once '../../backend/controllers/init.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


$userId = $_SESSION['user_id'];
$cartLogic = new Cart($conn, $userId);
$cartItems = $cartLogic->getCartItems();
$cartTotals = $cartLogic->calculateCartTotals($cartItems);
$cartItemsData = $cartLogic->getCartItemsData($cartItems);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My cart</title>

    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Icons Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!--CSS-->
    <link rel="stylesheet" href="../assets/style/cart.css">


    <!-- Cargar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>

    <?php include 'header.php'; ?>
    <main class="d-flex align-items-center justify-content-center font-family_cart mt-5 mb-5 h-100">
        <div class="container row d-flex flex-md-row flex-column">

            <div class="col-md-8 ">
                <div class="p-4 d-flex justify-content-md-between">
                    <h2 class="text-left">My cart</h2>
                    <div class="carrito-icono m-2">
                        <i class="fas fa-shopping-cart"></i> <span class="badge badge-primary"></span>
                    </div>
                </div>
                <hr style="border: 1px solid #4d194d" />
                <div class="p-5 text-center">
                    <?php if (!empty($cartItemsData)) : ?>
                        <?php foreach ($cartItemsData as $data) : ?>
                            <li class="d-flex justify-content-between align-items-center mb-3">
                                <div class="col-4 d-flex flex-column justify-content-center">
                                    <strong><?php echo htmlspecialchars($data['event']['event_name']); ?></strong>
                                    <p class="text-muted"><?php echo htmlspecialchars($data['event']['name']); ?> - <?php echo htmlspecialchars(date('d/m/Y', strtotime($data['event']['event_date']))); ?></p>
                                </div>

                                <div class="col-4 d-flex align-items-center justify-content-between rounded-pill px-3 py-1" style="background-color: #b44cb4; width: 100px;">
                                    <a class="btn p-0 border-0 text-white d-flex align-items-center justify-content-center"
                                        href="../../backend/controllers/cart.php?id=<?= $data['item']['id'] ?>&quantity=<?= $data['item']['quantity'] ?>&action=decrement"
                                        style="background-color: transparent; width: 20px; height: 20px; font-size: 16px;">
                                        <i class="fas fa-minus"></i>
                                    </a>

                                    <span class="text-white fs-6"><?php echo $data['item']['quantity']; ?></span>

                                    <a class="btn p-0 border-0 text-white d-flex align-items-center justify-content-center"
                                        href="../../backend/controllers/cart.php?id=<?= $data['item']['id'] ?>&quantity=<?= $data['item']['quantity'] ?>&action=increment"
                                        style="background-color: transparent; width: 20px; height: 20px; font-size: 16px;">
                                        <i class="fas fa-plus"></i>
                                    </a>

                                </div>

                                <div class="col-4"><?php echo number_format($data['event']['price'], 2); ?> € x <?php echo $data['item']['quantity']; ?> = <strong><?php echo number_format($data['subtotal'], 2); ?> €</strong>
                                    <a class=" ms-4 text-danger" href="../../backend/controllers/cart.php?id=<?= $data['item']['id'] ?>&action=deleteCart"><i class="fa-solid fa-trash"></i></a>
                                </div>
                            </li>

                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="col-12 text-center">
                            <p>Your cart is empty</p>
                        </div>
                        <button class="empty-cart-button"><a href="./catalog-events.php" class="text-white" style="text-decoration: none;">Find your event here!</a></button>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-4 pt-4">
                <h2 class="text-left mb-5">Total</h2>
                <div class="card p-4" style="padding-bottom: 3px; margin-bottom: 0px;">
                    <h2 class="resumen-pedido">Order Summary</h2>
                    <hr style="margin-top: 0px; border: 1px solid #4d194d; font-size: 24px;" />
                    <div class="text-center" style="height: 300px; font-size: 12px;">
                        <?php if (!empty($cartItemsData)) : ?>
                            <?php foreach ($cartItemsData as $data) : ?>
                                <li class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="d-flex flex-column justify-content-center">
                                        <strong><?php echo htmlspecialchars($data['event']['event_name']); ?></strong>
                                    </div>
                                    <div><strong><?php echo number_format($data['subtotal'], 2); ?> €</strong></div>
                                </li>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <div class="col-12 text-center">
                                <p>Your cart is empty</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <hr style="margin-top: 0px; border: 1px solid #4d194d" />
                    <div class="d-flex justify-content-between">
                        <span>Taxes</span>
                        <div><?php echo number_format($cartTotals['total_carrito'] * 0.1, 2); ?> €</div>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap">
                        <span>Management</span>
                        <div><?php echo number_format($cartTotals['total_quantity'], 2); ?> €</div>
                    </div>
                    <hr style=" border: 1px solid #4d194d">
                    <div class="d-flex justify-content-between flex-wrap">
                        <strong>Total</strong>
                        <div><strong><?php echo number_format($cartTotals['total_carrito'] + $cartTotals['total_quantity'], 2); ?> €</strong></div>
                    </div>
                </div>
            </div>
            <?php if (!empty($cartItemsData)) : ?>
            <div class=" d-flex justify-content-center row mb-4 mt-5 ">
                <button class="empty-cart-button  w-50 p-3 " type="submit" onclick="window.location.href='pago.php'">Pay</button>
            </div>
            <?php endif; ?>
            </form>
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