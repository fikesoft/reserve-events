<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
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
    <link rel="stylesheet" href="../assets/style/footer.css">
    <link rel="stylesheet" href="../assets/style/header.css">

    <!-- Cargar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <!-- Encabezado -->
    <header class="d-flex justify-content-center justify-content-md-between p-3 flex-md-row flex-column">
        <div class="d-flex flex-md-row flex-column align-items-center gap-4">
            <img class="logo-header" src="../assets/img/logo.png" alt="Logo de la empresa">
            <nav class="d-flex flex-grow-1 justify-content-center justify-content-md-start">
                <ul class="d-flex gap-4 m-0 p-0 list-unstyled align-items-center justify-content-start">
                    <li><a href="home.php" class="nav-header">Home</a></li>
                    <li><a href="catalog-events.html" class="nav-header">Events</a></li>
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

    <main class="d-flex align-items-center justify-content-center font-family_cart mt-5 mb-5">
        <div class="container row d-flex flex-md-row flex-column">

            <div class="col-md-8 ">
                <div class="p-4 d-flex justify-content-md-between">
                    <h2 class="text-left">My cart</h2>
                    <div class="carrito-icono m-2">
                        <i class="fas fa-shopping-cart"></i> <span class="badge badge-primary"></span>
                    </div>
                </div>
                <hr style="border: 1px solid #4d194d"/>
                <div class="p-5 text-center">
                    <?php
                        // Conexión a la base de datos
                        require_once '../../backend/config/database.php';

                        try {
                            // Consulta SQL para obtener los eventos en el carrito para el usuario
                            $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
                            $stmt->bind_param("i", $_SESSION['user_id']);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Verificar si hay resultados
                            if ($result->num_rows > 0) {
                                $total_carrito = 0;
                                // Iterar sobre los resultados
                                while ($product_cart = $result->fetch_assoc()) {
                                    $event_id = $product_cart['event_id'];
                                    $quantity = $product_cart['quantity'];

                                    $sqlEvt = "SELECT * FROM events WHERE id = {$event_id}";                         
                                    $resultEvt = $conn->query($sqlEvt);
                                    $event = $resultEvt->fetch_assoc();

                                    if($event){
                                        $subtotal = $event['price'] * $quantity;
                                        $total_carrito += $subtotal;
                    ?>
                                        <li class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="col-4 d-flex flex-column justify-content-center">
                                                <strong><?php echo htmlspecialchars($event['event_name']); ?></strong>
                                                <p class="text-muted"><?php echo htmlspecialchars($event['name']); ?> - <?php echo htmlspecialchars(date('d/m/Y', strtotime($event['event_date']))); ?></p>
                                            </div>

                                            <div class="col-4 d-flex align-items-center justify-content-between rounded-pill px-3 py-1" style="background-color: #b44cb4; width: 100px;">
                                                <a class="btn p-0 border-0 text-white d-flex align-items-center justify-content-center"
                                                    href="../../backend/controllers/update_cart.php?id=<?= $product_cart['id'] ?>&quantity=<?= $quantity ?>&action=decrement"
                                                    style="background-color: transparent; width: 20px; height: 20px; font-size: 16px;">
                                                    <i class="fas fa-minus"></i>
                                                </a>

                                                <span class="text-white fs-6"><?php echo $quantity; ?></span>

                                                <a class="btn p-0 border-0 text-white d-flex align-items-center justify-content-center"
                                                    href="../../backend/controllers/update_cart.php?id=<?= $product_cart['id'] ?>&quantity=<?= $quantity ?>&action=increment"
                                                    style="background-color: transparent; width: 20px; height: 20px; font-size: 16px;">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                                
                                            </div>
                                            <div class="col-4"><?php echo number_format($event['price'], 2); ?> € x <?php echo $quantity; ?> = <strong><?php echo number_format($subtotal, 2); ?> €</strong>
                                            <a class=" ms-4 text-danger" href="../../backend/controllers/delete_cart.php?id=<?= $product_cart['id'] ?>"><i class="fa-solid fa-trash"></i></a></div>
                                        </li>

                    <?php
                                    }
                                }
                            } else {
                                // Si no hay eventos en el carrito, mostrar un mensaje
                                echo '<div class="col-12 text-center"><p>Your cart is empty</p></div>
                                <button class="empty-cart-button">Find your event here!</button>';
                            }
                        } catch (Exception $e) {
                            // Manejar errores
                            echo '<div class="col-12 text-center"><p>Error loading cart: ' . htmlspecialchars($e->getMessage()) . '</p></div>';
                        }
                        ?>
                </div>
            </div>

            <div class="col-md-4 pt-4">
                <h2 class="text-left mb-5">Total</h2>
                <div class="card p-4" style="padding-bottom: 3px; margin-bottom: 0px;">
                    <h2 class="resumen-pedido">Order Summary</h2>
                    <hr style="margin-top: 0px; border: 1px solid #4d194d; font-size: 24px;"/>
                    <div class="text-center" style="height: 300px; font-size: 12px;">
                    <?php
                        // Conexión a la base de datos
                        require_once '../../backend/config/database.php';

                        try {
                            // Consulta SQL para obtener los eventos en el carrito para el usuario
                            $sql = "SELECT * FROM cart WHERE user_id = {$_SESSION['user_id']}";                         
                            $result = $conn->query($sql);
                            $total_carrito = 0;
                            $total_quantity = 0;

                            // Verificar si hay resultados
                            if ($result->num_rows > 0) {

                                // Iterar sobre los resultados
                                while ($product_cart = $result->fetch_assoc()) {
                                    $event_id = $product_cart['event_id'];
                                    $quantity = $product_cart['quantity'];

                                    $sqlEvt = "SELECT * FROM events WHERE id = {$product_cart['event_id']}";                         
                                    $resultEvt = $conn->query($sqlEvt);
                                    $event = $resultEvt->fetch_assoc();

                                    if($event){
                                        $subtotal = $event['price'] * $quantity;
                                        $total_carrito += $subtotal;
                                        $total_quantity += $quantity;
                    ?>
                                        <li class="d-flex justify-content-between ali
                                        gn-items-center mb-3">
                                            <div class="d-flex flex-column justify-content-center">
                                                <strong><?php echo htmlspecialchars($event['event_name']); ?></strong>
                                            </div>
                                            <div><strong><?php echo number_format($subtotal, 2); ?> €</strong></div>
                                        </li>

                    <?php
                                    }
                                }
                            } else {
                                // Si no hay eventos en el carrito, mostrar un mensaje
                                echo '<div class="col-12 text-center"><p>Your cart is empty</p></div>';
                            }
                        } catch (Exception $e) {
                            // Manejar errores
                            echo '<div class="col-12 text-center"><p>Error loading cart: ' . htmlspecialchars($e->getMessage()) . '</p></div>';
                        }
                        ?>
                    </div>
                    <hr style="margin-top: 0px; border: 1px solid #4d194d" />
                    <div class="d-flex justify-content-between">
                        <span>Taxes</span>
                        <div><?php echo number_format($total_carrito*0.1, 2); ?> €</div>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap">
                        <span>Management</span>
                        <div><?php echo number_format($total_quantity, 2); ?> €</div>
                    </div>
                    <hr style=" border: 1px solid #4d194d" >
                    <div class="d-flex justify-content-between flex-wrap">
                        <strong>Total</strong>
                        <div><strong><?php echo number_format($total_carrito + $total_quantity, 2); ?> €</strong></div>
                    </div>
                </div>
            </div>
            <?php
                if ($result->num_rows > 0) {
            ?>
            <div class=" d-flex justify-content-center row mb-4 mt-5 ">
                <button class="empty-cart-button  w-50 p-3 " type="submit" onclick="window.location.href='pago.html'">Pagar</button>
            </div>
            <?php
                            }
            ?>
            </form>
        </div>

    </main>

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
                        <p class="text-nowrap m-1"><i class="fa-solid fa-map-marker-alt me-2"></i> Calle Falsa 123, Madrid, España</p>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>