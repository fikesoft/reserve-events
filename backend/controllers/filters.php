<?php
include(__DIR__ . '/connection.php');

//Consultas
$result_city = $conn->query("SELECT DISTINCT city FROM events ORDER BY city ASC");
$result_style = $conn->query("SELECT DISTINCT style FROM events ORDER BY style ASC");




if($result_city === false || $result_style === false) {
    die ("Error en la consulta: " . $conn->error);
}
?>

