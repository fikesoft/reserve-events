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

// Array para almacenar los errores de validación
$errors = [];

// Función para validar los datos de la tarjeta de crédito (solo si se selecciona ese método)
function validateCreditCard($paymentMethod, $holder, $month, $year, $number, $cvv) {
    $errors = [];
    if ($paymentMethod === 'credit-card') {
        if (empty(trim($holder))) {
            $errors['card-holder'] = "El nombre del titular de la tarjeta es obligatorio.";
        }
        if (empty(trim($month))) {
            $errors['month-date-card'] = "El mes de caducidad es obligatorio.";
        }
        if (empty(trim($year))) {
            $errors['year-date-card'] = "El año de caducidad es obligatorio.";
        }
        if (empty(trim($number))) {
            $errors['pago-card-number'] = "El número de tarjeta es obligatorio.";
        }
        if (empty(trim($cvv))) {
            $errors['pago-cvv'] = "El CVV es obligatorio.";
        }
    }
    return $errors;
}

function calculateCartTotal($cartTotals, $shipping_method) {
    $shippingPrices = [
        'eticket' => 1,
        'ticket-fisico' => 3,
        'express-ticket-fisico' => 5
    ];

    $shippingPrice = $shippingPrices[$shipping_method] ?? 0;

    return $cartTotals['total_carrito'] + $cartTotals['total_quantity'] + $shippingPrice;
}


//Verificar si se han eenviado dato por POST
if ($_SERVER["REQUEST_METHOD"]=="POST") {
    // Recuperar los datos del formulario
    $country = $_POST["country_name"] ?? "";
    $province = $_POST["province_name"] ?? "";
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

     // Validar datos de la tarjeta de crédito si el método de pago es "credit-card"
     $creditCardErrors = validateCreditCard($payment_method, $card_holder, $card_expiry_month, $card_expiry_year, $card_number, $cvv);
     $errors = array_merge($errors, $creditCardErrors);

     // Si hay errores, devolvemos una respuesta (por ejemplo, en formato JSON)
    if (!empty($errors)) {
        header('Content-Type: application/json');
        echo json_encode(['errors' => $errors]);
        exit();
    }

    // Iniciar la transacción
    $conn->begin_transaction();
    
    try {
        // Insertar el pedido con los datos de dirección y pago integrados
        $stmt_order = $conn->prepare("INSERT INTO orders (order_date, terms_accepted, privacy_policy_accepted, total, country, province, city, zip_code,
            address, payment_method, card_holder, card_expiry_month, card_expiry_year, card_number, cvv, shipping_method) VALUES (NOW(),?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

        $stmt_order->bind_param("ssdssssssssssss", $terms_accepted, $privacy_policy_accepted, calculateCartTotal($cartTotals, $shipping_method), $country, $province, $city, $zip_code, $address, $payment_method, $card_holder,
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

        $_SESSION['order_id'] = $order_id;
        header("Location: ../../frontend/static/confirmation.php");
        exit();

    } catch (Exception $e) {
        // Si ocurre algún error, deshacer la transacción
        $conn->rollback();
        echo "Error al procesar el pedido: " . $e->getMessage();
    }

}

?>