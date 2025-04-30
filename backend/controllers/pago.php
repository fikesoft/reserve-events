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
    return $cartTotals['total_carrito'] + $cartTotals['total_quantity'] + getShippingPrice($shipping_method);
}

function getShippingPrice($shipping_method){
    $shippingPrices = [
        'eticket' => 1,
        'ticket-fisico' => 3,
        'express-ticket-fisico' => 5
    ];

    return $shippingPrices[$shipping_method] ?? 0;
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
        $stmt_order = $conn->prepare("INSERT INTO orders (user_id, order_date, terms_accepted, privacy_policy_accepted, total, country, province, city, zip_code,
            address, payment_method, card_holder, card_expiry_month, card_expiry_year, card_number, cvv, shipping_method) VALUES (?,NOW(),?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

        $stmt_order->bind_param("issdssssssssssss", $userId, $terms_accepted, $privacy_policy_accepted, calculateCartTotal($cartTotals, $shipping_method), $country, $province, $city, $zip_code, $address, $payment_method, $card_holder,
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


        // Seccion de envio de email

        $stmt_user = $conn->prepare("SELECT email FROM users WHERE id = ?");
        $stmt_user->bind_param("i", $userId);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();

        if ($row_user = $result_user->fetch_assoc()) {
            $user_email = $row_user['email'];
            $subject = 'Confirmation of your order #' . $order_id . ' at Random Events';

            $template_path = '../../frontend/static/email.php';
            $body = file_get_contents($template_path);

            // Generar la parte de los items del carrito
            $cart_items_html = '';
            foreach ($cartItemsData as $data) {
                $cart_items_html .= '
                            <tr>
                                <td><img src="' . htmlspecialchars($data['event']['image_url']) . '" alt="' . htmlspecialchars($data['event']['event_name']) . '" style="max-width: 50px; vertical-align: middle; margin-right: 10px;">' . htmlspecialchars($data['event']['event_name']) . '</td>
                                <td>' . $data['item']['quantity'] . '</td>
                                <td>' . number_format($data['subtotal'], 2) . ' €</td>
                            </tr>';
            }

            // Reemplazar los marcadores de posición con los datos dinámicos
            $replacements = [
                '{order_id}' => $order_id,
                '{cart_items}' => $cart_items_html,
                '{subtotal_cart}' => number_format($cartTotals['total_carrito'], 2),
                '{taxes}' => number_format($cartTotals['total_carrito'] * 0.1, 2),
                '{management_fees}' => number_format($cartTotals['total_quantity'], 2),
                '{shipping}' => number_format(getShippingPrice($shipping_method), 2),
                '{total_cart}' => number_format(calculateCartTotal($cartTotals, $shipping_method), 2),
                '{country}' => htmlspecialchars($country),
                '{province}' => htmlspecialchars($province),
                '{city}' => htmlspecialchars($city),
                '{zip_code}' => htmlspecialchars($zip_code),
                '{address}' => htmlspecialchars($address),
                '{payment_method}' => htmlspecialchars($payment_method),
                '{shipping_method}' => htmlspecialchars($shipping_method),
            ];

            foreach ($replacements as $placeholder => $value) {
                $body = str_replace($placeholder, $value, $body);
            }

            // Email headers
            $headers = "From: Random Events <randomeventsinfo@gmail.com>\r\n"; 
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();

            // Envio de email
            if (!mail($user_email, $subject, $body, $headers)) {
                error_log("Error sending HTML confirmation email to user " . $user_email);
            }

            $stmt_user->close();
        }

        header("Location: ../../frontend/static/confirmation.php");
        exit();
        

    } catch (Exception $e) {
        // Si ocurre algún error, deshacer la transacción
        $conn->rollback();
        echo "Error al procesar el pedido: " . $e->getMessage();
    }

}

?>