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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forma de pago y envío</title>

    <!-- Cargar Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Cargar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!--Iconos Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../assets/style/footer.css">
    <link rel="stylesheet" href="../assets/style/header.css">
    <link rel="stylesheet" href="../assets/style/pago.css">
    
</head>

<body>

    <!-- Encabezado -->
    <header class="d-flex justify-content-center justify-content-md-between p-3 flex-md-row flex-column">
        <div class="d-flex flex-md-row flex-column align-items-center gap-4">
            <img class="logo-header" src="../assets/img/logo.png" alt="Logo de la empresa">
            <nav class="d-flex flex-grow-1 justify-content-center justify-content-md-start">
                <ul class="d-flex gap-4 m-0 p-0 list-unstyled align-items-center justify-content-start">
                    <li><a href="home.html" class="nav-header">Home</a></li>
                    <li><a href="catalog-events.php" class="nav-header">Events</a></li>
                    <li><a href="about-us.html" class="nav-header">About us</a></li>
                </ul>
            </nav>
        </div>

        <!-- Buscador e Iconos -->
        <div class="d-flex align-items-center gap-4 mt-3 mt-md-0 flex-md-row flex-column">
            <div class="d-flex align-items-center search-box">
                <input class="search-box-input" type="text" placeholder="Search...">
                <button class="search-box-button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <div class="d-flex">    
                <a href="cart.php" class="icons mx-3"><i class="fa-solid fa-cart-shopping"></i></a>
                <a href="login.php" class="icons mx-3"><i class="fa-solid fa-user"></i></a>
            </div>

        </div>
    </header>

    <!-- Contenedor del formulario completo, incluyendo resumen de pago -->

    <div class="pago-container container gap-1">

        <!--Contenedor del formulario hasta botón pagar-->

        <div class="pago-form-container container">

            <!--Contenedor solo título "Tus datos"-->

            <div class="pago-seccion-row row">
                <h1 class="pago-h1-datos">Shipping Information</h1>
            </div>

            <!--Contenedor formulario sección País y Provincia-->

            <div class="pago-seccion-row row">
                <h6 class="pago-titulo-seccion mb-0">Your address details</h6>
                <hr class="mt-0 mb-0">
                <i class="pago-mandatory text-end mt-0 fs-6">*Mandatory field</i>

                <!--Columna de Pais-->

                <div class="pago-form-col col mt-3 ms-0">
                    <form action="../../backend/controllers/pago.php" method="post">
                        <label class="d-flex justify-content-start text-start" for="country">Country*</label>
                        <select class="pago-select border border-black rounded text-center" name="country" id="country">
                            <option value="España" selected>España</option>
                            <option value="">1</option>
                            <option value="">2</option>
                            <option value="">3</option>
                            <option value="">4</option>
                        </select>
                </div>

                <!--Columna de Provincia-->

                <div class="col mt-3">
                    <label class="d-flex justify-content-start text-start" for="province">Province*</label>
                    <select class="pago-select border border-black rounded text-center" name="province" id="province">
                        <option value="Madrid" selected>Madrid</option>
                        <option value="">1</option>
                        <option value="">2</option>
                        <option value="">3</option>
                        <option value="">4</option>
                    </select>
                </div>
            </div>

            <!--Fila de ciudad y codigo postal-->

            <div class="row mt-3">

                <!--Columna de ciudad-->

                <div class="col mt-3">
                    <label class="d-flex" for="city">City*</label>
                    <select class="pago-select border border-black rounded text-center" name="city" id="city">
                        <option value="Madrid">Madrid</option>
                        <option value="">1</option>
                        <option value="">2</option>
                        <option value="">3</option>
                        <option value="">4</option>
                    </select>
                </div>

                <!--Columna de codigo postal-->

                <div class="col mt-3">
                    <label class="d-flex" for="zip-code">Zip Code*</label>
                    <input class="pago-select border border-black rounded text-center" type="text" id="zip-code"
                        name="zip-code" maxlength="9" minlength="4" pattern="\d{4,9}" placeholder="*Zip Code" required>
                </div>
            </div>

            <!--Fila y columna de direccion-->

            <div class="row mt-3">
                <label class="d-flex" for="address">Address</label>
                <input class="border border-black rounded text-center w-70" type="text" id="address" name="address"
                    placeholder="*Address" required>
            </div>

            <!--Contenedor de título "Detalles sobre el método de pago"-->

            <div class="pago-seccion-row row mt-3">
                <h6 class="pago-titulo-seccion mb-0 mt-3">Details about the payment method</h6>
                <hr class="mb-3">
            </div>

            <!--Contenedor de input radio para tarjeta de crédito o paypal-->

            <div class="pago-seccion-row row">

                <div class="col text-nowrap">
                    <input type="radio" id="credit-card" name="payment-method" value="credit-card" required>
                    <label for="credit-card">Credit Card</label>
                </div>
                <div class="col">
                    <input type="radio" id="paypal" name="payment-method" value="paypal" required>
                    <label for="paypal">PayPal</label>
                </div>

            </div>

            <!--Contenedor de la tarjeta, para poner los datos de la misma-->

            <div class="pago-datos-tarjeta container p-2 mt-3 mb-3"  id="div-credit-card" style=" max-width: 280px; float: left;" hidden >

                <!--Fila titulo y imagen de tarjeta-->

                <div class="row">

                    <!--Columna de titulo de tarjeta-->

                    <div class="col">
                        <h6 class="pago-credit-card-dates">Credit Card</h6>
                    </div>

                    <!--Columna de imagen de tarjeta-->

                    <div class="col">
                        <img src="../assets/img/visa.png" alt="visa" class="img-fluid pago-visa" style="float: right; ">
                    </div>
                </div>

                <!--Fila de input text para holder-->

                <div class="row mb-1">
                    <input type="text" id="card-holder" name="card-holder"
                        class="pago-card-holder border border-grey rounded text-center" placeholder="*Card Holder"
                        required>
                </div>

                <!--Fila para fecha de caducidad de tarjeta-->

                <div class="row mb-1">
                    <div class="col d-flex">
                        <input type="text" id="month-date-card" name="month-date-card" placeholder="MM"
                            class="pago-date-creditcard border border-grey rounded me-2 text-center" required>

                        <input type="text" id="year-date-card" name="year-date-card" placeholder="AA"
                            class="pago-date-creditcard border border-grey rounded text-center" required>
                    </div>

                </div>

                <!--Fila para número de tarjeta de crédito y cvv-->

                <div class="row d-flex">

                    <!--Número tarjeta de crédito-->

                    <div class="col">
                        <input type="text" id="pago-card-number" name="pago-card-number"
                            class="pago-card-number border border-grey rounded text-center" maxlength="19"
                            minlength="13" pattern="\d{13,19}" placeholder="*Card number" required>
                    </div>

                    <!--CVV-->

                    <div class="col">
                        <input type="text" id="pago-cvv" name="pago-cvv" placeholder="*CVV"
                            class="pago-input-cvv border border-grey rounded text-center" maxlength="3" pattern="\d{3}"
                            required style="max-width: 50px;">
                    </div>
                </div>
            </div>

            <!--Fila titulo "Forma de envío"-->

            <div class="pago-seccion-row row mt-3">
                <h6 class="pago-titulo-seccion mb-0">Shipping method</h6>
                <hr class="mt-0">
            </div>

            <!--Fila inputs radio para forma de envío-->

            <div class="pago-seccion-row row mt-3 mb-3 ms-2 justify-content-center d-flex flex-column">

                <div class="pago-formaenvio-row row border border-grey rounded mb-2">
                    <div class="col">
                        <label for="eticket">e-Ticket &nbsp; &nbsp; X€</label>
                    </div>
                    <div class="col-2">
                        <input type="radio" id="forma-pago" name="forma-pago" value="eticket" required>
                    </div>
                </div>

                <br>

                <div class="pago-formaenvio-row row border border-grey rounded mb-2">
                    <div class="col">
                        <label for="ticket-fisico"> Physical ticket &nbsp; &nbsp; X€</label>
                    </div>
                    <div class="col-2">
                        <input type="radio" id="forma-pago" name="forma-pago" value="ticket-fisico" required>
                    </div>
                </div>

                <br>

                <div class="pago-formaenvio-row row border border-grey rounded mb-2">
                    <div class="col">
                        <label for="express-ticket-fisico">Express Physical ticket &nbsp; &nbsp; X€</label>
                    </div>
                    <div class="col-2">
                        <input type="radio" id="forma-pago" name="forma-pago" value="express-ticket-fisico" required>
                    </div>
                </div>
            </div>

            <!--Fila para título términos y condiciones-->

            <div class="pago-seccion-row row mt-3 mb-3">
                <h6 class="pago-titulo-seccion mb-0">Terms and conditions</h6>
                <hr class="mt-0">
            </div>

            <!--Fila para checkbox para terminos y condiciones-->

            <div class="pago-terminos-row row d-flex mb-3 d-flex">
                <label class="mb-2" for="terms">
                <input type="checkbox" id="terms" name="terms" required> I have read and accept the terms and conditions
                </label>
                <br>
                
                <label class="mb-2" for="privacy-policy">
                <input type="checkbox" id="privacy-policy" name="privacy-policy" required> I have read and accept the privacy policy
                </label>
            
            </div>

            <!--Botón de pagar/aceptar-->

            <div class="row mb-4 mt-3 justify-content-center">
                <button class="pago-button-pagar w-50 p-3" type="submit">Pay</button>
            </div>
            </form>
        </div>

        <!--Contenedor de resumen de pago-->

        <div class="pago-resumen-container d-flex flex-column container-sm col-md-4 align-items-center justify-content-center">
                <div class="card p-4" style="padding-bottom: 3px; margin-bottom: 0px;">
                    <h2 class="resumen-pedido">Order Summary</h2>
                    <hr style="margin-top: 0px; border: 1px solid #4d194d; font-size: 24px;"/>
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
                        <div class="col-12 text-center"><p>Your cart is empty</p></div>
                        <?php endif; ?>
                </div>
                    <hr style="margin-top: 0px; border: 1px solid #4d194d" />
                    <div class="d-flex justify-content-between">
                        <span>Taxes</span>
                        <div><?php echo number_format($cartTotals['total_carrito']*0.1, 2); ?> €</div>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap">
                        <span>Management</span>
                        <div><?php echo number_format($cartTotals['total_quantity'], 2); ?> €</div>
                    </div>
                    <hr style=" border: 1px solid #4d194d" >
                    <div class="d-flex justify-content-between flex-wrap">
                        <strong>Total</strong>
                        <div><strong><?php echo number_format($cartTotals['total_carrito'] + $cartTotals['total_quantity'], 2); ?> €</strong></div>
                    </div>
                </div>
        </div>
        
    </div>



    <!-- Footer -->
    <footer class="container-fluid p-5">
        <div class="d-flex flex-column align-items-center">
            <div class="row">
                <!-- Menú de navegación -->
                <nav class=" col-12 col-md-6 mt-3">
                    <ul class="list-unstyled">
                        <li><a href="home.php" class="nav-footer">Home</a></li>
                        <li><a href="catalog-events.html" class="nav-footer">Events</a></li>
                        <li><a href="about-us.html" class="nav-footer">About us</a></li>
                    </ul>
                </nav>

                <!-- Información de contacto -->
                <div class="footer-contact col-12 col-md-6 mt-3">
                    <p class="text-nowrap m-1"><i class="fa-solid fa-phone me-2"></i> +34 123 456 789</p>
                    <p class="text-nowrap m-1"><i class="fa-solid fa-envelope me-2"></i> contacto@empresa.com</p>
                    <p class="text-nowrap m-1"><i class="fa-solid fa-map-marker-alt me-2"></i> Calle Falsa 123, Madrid,
                        España</p>
                </div>
            </div>
        </div>

        <!-- Redes Sociales -->
        <div class="d-flex justify-content-center align-items-center gap-3 mt-3 col-12">
            <a href="#" class="footer-social"><i class="fa-brands fa-facebook"></i></a>
            <a href="#" class="footer-social"><i class="fa-brands fa-twitter"></i></a>
            <a href="#" class="footer-social"><i class="fa-brands fa-instagram"></i></a>
            <a href="#" class="footer-social"><i class="fa-brands fa-linkedin"></i></a>
        </div>


        <!-- Derechos de autor -->
        <div class="footer-bottom text-center pt-4 col-12">
            <p>&copy; 2025 Random Events. All rights reserved.</p>
        </div>

    </footer>

    <script src="../js/pago.js"></script>
</body>

</html>