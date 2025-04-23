<?php 
require_once '../../backend/controllers/init.php';
// Incluir la conexión a la base de datos
require_once '../config/database.php';
require_once '../../backend/controllers/cart.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../frontend/static/login.php"); 
    exit();
}

$userId = $_SESSION['user_id'];

$cartItems = $cartLogic->getCartItems();
$cartTotals = $cartLogic->calculateCartTotals($cartItems);
$cartItemsData = $cartLogic->getCartItemsData($cartItems);


//Verificar si se han eenviado dato por POST
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    // Recuperar los datos del formulario
    $country = $_POST["country"] ?? "";
    $province = $_POST["province"] ?? "";
    $city = $_POST["city"] ?? '';
    $zip_code = $_POST["zip-code"] ?? "";
    $address = $_POST["address"] ?? "";
    $payment_method = $_POST["payment-method"] ?? ""; 
    $terms_accepted = ($_POST["terms"] ?? "false") === "on" ? true : false; // terminos, condiciones
    $privacy_policy_accepted = ($_POST["privacy-policy"] ?? "false") === "on" ? true : false;  // politica y privacidad
    $shipping_method = $_POST["forma-pago"] ?? ""; //e-ticket, ticket_fisico, espress_ticket_fisico

    //Datos de la tarjeta de credito, cuando lo selecciones

    $card_holder = $_POST["card-holder"] ?? "";
    $card_expiry_month = $_POST["month-date-card"] ?? ""; 
    $card_expiry_year = $_POST["year-date-card"] ?? "";
    $card_number = $_POST["pago-card-number"] ?? "";
    $cvv = $_POST["pago-cvv"] ?? "";

    // Iniciar la transacción
    $conn->begin_transaction();
    
    try {
        // Insertar el pedido con los datos de dirección y pago integrados
        $stmt_order = $conn->prepare("INSERT INTO orders (order_date, terms_accepted, privacy_policy_accepted, total, country, province, city, zip_code,
            address, payment_method, card_holder, card_expiry_month, card_expiry_year, card_number, cvv, shipping_method) VALUES (NOW(),?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

        $stmt_order->bind_param("ssdssssssssssss", $terms_accepted, $privacy_policy_accepted, $cartTotals['total_carrito'], $country, $province, $city, $zip_code, $address, $payment_method, $card_holder,
            $card_expiry_month, $card_expiry_year, $card_number, $cvv, $shipping_method);

        $stmt_order->execute();
        $order_id = $conn->insert_id;
        $stmt_order->close();

        // Insertar los detalles del pedido en order_details
        foreach ($cartItemsData as $data) :
        $stmt_order_detail = $conn->prepare("INSERT INTO order_detail (order_id, event_id, quantity, unit_price) VALUES (?,?,?,?)");
        $stmt_order_detail->bind_param("iiid", $order_id, $data['event']['id'], $data['item']['quantity'], $data['event']['price']);

        $stmt_order_detail->execute();
        $stmt_order_detail->close();
        endforeach;
        
        // Eliminar los productos comprados del carrito
        $stmt_delete_cart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt_delete_cart->bind_param("i", $userId);
        $stmt_delete_cart->execute();
        $stmt_delete_cart->close();
        

        $conn->commit();
        echo "Pedido realizado con éxito. ID de la orden: " . $order_id;

    } catch (Exception $e) {
        // Si ocurre algún error, deshacer la transacción
        $conn->rollback();
        echo "Error al procesar el pedido: " . $e->getMessage();
    }

}

?>