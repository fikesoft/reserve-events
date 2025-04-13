<main class="d-flex align-items-center justify-content-center mt-5 mb-5">
    <div class="container row d-flex flex-md-row flex-column">

        <div class="col-md-8 ">
            <div class="p-4 d-flex justify-content-md-between">
                <h2 class="text-left">My cart</h2>
                <div class="carrito-icono m-2">
                    <i class="fas fa-shopping-cart"></i> <span class="badge badge-primary"></span>
                </div>
            </div>
            <hr style="border: 1px solid #4d194d"/>
            <div class="p-4">
                <?php
                // Conexión a la base de datos
                require_once '../../backend/config/database.php';

                // Iniciar la sesión (asegúrate de que esté al principio del archivo)
                session_start();

                try {
                    // Verificar si el user_id está en la sesión
                    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== null) {
                        $userId = $_SESSION['user_id'];

                        // Consulta SQL para obtener los eventos en el carrito para el usuario
                        $sql_cart = "SELECT * FROM cart WHERE user_id = :user_id";
                        $stmt_cart = $conn->prepare($sql_cart);
                        $stmt_cart->bindParam(':user_id', $userId, PDO::PARAM_INT);
                        $stmt_cart->execute();
                        $cart_items = $stmt_cart->fetchAll(PDO::FETCH_ASSOC);

                        if (!empty($cart_items)) {
                            echo '<ul class="list-unstyled">';
                            $total_carrito = 0;

                            foreach ($cart_items as $item) {
                                $event_id = $item['event_id'];
                                $quantity = $item['quantity'];

                                // Consulta SQL para obtener la información del evento desde la tabla 'events'
                                $sql_event = "SELECT * FROM events WHERE id = :event_id";
                                $stmt_event = $conn->prepare($sql_event);
                                $stmt_event->bindParam(':event_id', $event_id, PDO::PARAM_INT);
                                $stmt_event->execute();
                                $event = $stmt_event->fetch(PDO::FETCH_ASSOC);

                                if ($event) {
                                    $subtotal = $event['price'] * $quantity;
                                    $total_carrito += $subtotal;
                                    ?>
                                    <li class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                            <strong><?php echo htmlspecialchars($event['event_name']); ?></strong>
                                            <p class="text-muted"><?php echo htmlspecialchars($event['name']); ?> - <?php echo htmlspecialchars(date('d/m/Y', strtotime($event['event_date']))); ?></p>
                                        </div>
                                        <div>
                                            Cantidad: <input type="number" value="<?php echo $quantity; ?>" min="1" style="width: 60px;">
                                            <button class="btn btn-sm btn-danger ms-2"><i class="fa fa-trash"></i></button>
                                        </div>
                                        <div><?php echo number_format($event['price'], 2); ?> € x <?php echo $quantity; ?> = <strong><?php echo number_format($subtotal, 2); ?> €</strong></div>
                                    </li>
                                    <?php
                                } else {
                                    echo '<p class="text-danger">Error: No se encontró información para el evento con ID ' . htmlspecialchars($event_id) . ' en el carrito.</p>';
                                }
                            }
                            echo '</ul>';
                            echo '<hr style="border-top: 1px solid #4d194d;">';
                            echo '<p class="text-end"><strong>Total del carrito: ' . number_format($total_carrito, 2) . ' €</strong></p>';
                            echo '<div class="text-center"><button class="btn btn-success">Proceed to Checkout</button></div>';

                        } else {
                            echo '<div class="col-12 text-center"><p>Your cart is empty</p><button class="empty-cart-button">Find your event here!</button></div>';
                        }
                    } else {
                        echo '<div class="col-12 text-center"><p>Please log in to view your cart.</p><a href="login.php" class="btn btn-primary">Log In</a></div>';
                    }

                } catch (PDOException $e) {
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
                <div class="font-size-12">
                    <?php
                    if (!empty($cart_items)) {
                        $total_resumen = 0;
                        foreach ($cart_items as $item) {
                            $event_id = $item['event_id'];
                            $quantity = $item['quantity'];

                            $sql_event_resumen = "SELECT event_name, price FROM events WHERE id = :event_id";
                            $stmt_event_resumen = $conn->prepare($sql_event_resumen);
                            $stmt_event_resumen->bindParam(':event_id', $event_id, PDO::PARAM_INT);
                            $stmt_event_resumen->execute();
                            $event_resumen = $stmt_event_resumen->fetch(PDO::FETCH_ASSOC);

                            if ($event_resumen) {
                                $subtotal_resumen_item = $event_resumen['price'] * $quantity;
                                $total_resumen += $subtotal_resumen_item;
                                echo '<div class="d-flex justify-content-between">';
                                echo '<span>' . htmlspecialchars($event_resumen['event_name']) . ' x ' . $quantity . '</span>';
                                echo '<span>' . number_format($subtotal_resumen_item, 2) . ' €</span>';
                                echo '</div>';
                            }
                        }
                        echo '<hr style="margin-top: 10px; border: 1px solid #4d194d" />';
                        echo '<div class="d-flex justify-content-between">';
                        echo '<span>Subtotal</span>';
                        echo '<span>' . number_format($total_resumen, 2) . ' €</span>';
                        echo '</div>';
                        echo '<div class="d-flex justify-content-between">';
                        echo '<span>Taxes</span>';
                        echo '<span>0.00 €</span>';
                        echo '</div>';
                        echo '<div class="d-flex justify-content-between flex-wrap">';
                        echo '<span>Management</span>';
                        echo '<span>0.00 €</span>';
                        echo '</div>';
                        echo '<hr style=" border: 1px solid #4d194d" >';
                        echo '<div class="d-flex justify-content-between flex-wrap">';
                        echo '<strong>Total</strong>';
                        echo '<strong>' . number_format($total_resumen, 2) . ' €</strong>';
                        echo '</div>';
                        echo '<button class="btn btn-success mt-3 w-100">Proceed to Checkout</button>';
                    } else {
                        echo '<div class="text-center" style="height: 300px; font-size: 12px;">';
                        echo '<p>Your cart is empty</p>';
                        echo '</div>';
                        echo '<hr style="margin-top: 0px; border: 1px solid #4d194d" />';
                        echo '<div class="d-flex justify-content-between">';
                        echo '<span>Taxes</span>';
                        echo '<span>0,00 €</span>';
                        echo '</div>';
                        echo '<div class="d-flex justify-content-between flex-wrap">';
                        echo '<span>Management</span>';
                        echo '<span>0,00 €</span>';
                        echo '</div>';
                        echo '<hr style=" border: 1px solid #4d194d" >';
                        echo '<div class="d-flex justify-content-between flex-wrap">';
                        echo '<strong>Total</strong>';
                        echo '<strong>0,00 €</strong>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>