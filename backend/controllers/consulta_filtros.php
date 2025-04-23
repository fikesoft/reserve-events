<?php
include(__DIR__ . '/connection.php');
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);



$city = $_POST['city'] ?? '';
$event_date = $_POST['event_date'] ?? '';
$price = $_POST['price'] ?? '';
$style = $_POST['style'] ?? '';

//Verificar los valores de los filtros antes de guardarlos en la sesión
//var_dump($city, $event_date, $price, $style);

//Almacena los filtros en la sesión
$_SESSION['city'] = $city;
$_SESSION['event_date'] = $event_date;  
$_SESSION['price'] = $price;
$_SESSION['style'] = $style;

var_dump($_SESSION);

$conn->close();

header("Location: /../frontend/static/catalog-events.php");
exit();

?>