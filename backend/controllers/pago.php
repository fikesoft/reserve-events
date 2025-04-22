<?php 
session_start();
// Incluir la conexión a la base de datos
require_once '../config/database.php';

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

    //Datos de la tarjeta de credito (solo si selecciona este metodo)

    $card_holder = $_POST["card-holder"] ?? "";
    $card_expiry_month = $_POST["month-date-card"] ?? ""; 
    $card_expiry_year = $_POST["year-date-card"] ?? "";
    $card_number = $_POST["pago-card-number"] ?? "";
    $cvv = $_POST["pago-cvv"] ?? "";


    try {
        // Insertar la orden con los datos de dirección y pago integrados
        $stmt_orden = $conn->prepare("INSERT INTO orders (order_date, terms_accepted, privacy_policy_accepted, total, country, province, city, zip_code,
            address, payment_method, card_holder, card_expiry_month, card_expiry_year, card_number, cvv, shipping_method) VALUES (NOW(),?,?,0.00,?,?,?,?,?,?,?,?,?,?,?,?)");

        $stmt_orden->bind_param("ssssssssssssss", $terms_accepted, $privacy_policy_accepted, $country, $province, $city, $zip_code, $address, $payment_method, $card_holder,
            $card_expiry_month, $card_expiry_year, $card_number, $cvv, $shipping_method);

        $stmt_orden->execute();
        $orden_id = $conn->insert_id;
        $stmt_orden->close();

    // Aquí podrías añadir la lógica para guardar los items del carrito en una tabla separada 'detalles_orden'
    // relacionando el orden_id con los productos y cantidades.

        $conn->commit();
        echo "Pedido realizado con éxito. ID de la orden: " . $orden_id;

    } catch (Exception $e) {
        // Si ocurre algún error, deshacer la transacción
        $conn->rollback();
        echo "Error al procesar el pedido: " . $e->getMessage();
    }

}
