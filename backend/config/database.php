<?php

$host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'random_events_db';

// Crear la conexión inicial sin seleccionar una base de datos
$conn = new mysqli($host, $db_user, $db_pass);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Crear la base de datos si no existe
$sql_create_database = "CREATE DATABASE IF NOT EXISTS $db_name";

if ($conn->query($sql_create_database) === TRUE) {
    // La base de datos se creó correctamente o ya existía
} else {
    die("Error al crear la base de datos: " . $conn->error);
}

// Seleccionar la base de datos creada
$conn->select_db($db_name);


$conn->set_charset("utf8");


$sql_create_table_users = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";

if ($conn->query($sql_create_table_users) !== TRUE) {
    die("Error al crear la tabla de usuarios: " . $conn->error);
}



$sql_create_table_events = "
CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    event_name VARCHAR(150) NOT NULL,
    description TEXT,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    image_url VARCHAR(255),
    city VARCHAR(100),
    location VARCHAR(255),
    style VARCHAR(100),
    price DECIMAL(10, 2),
    number_of_tickets INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";

if ($conn->query($sql_create_table_events) !== TRUE) {
    die("Error al crear la tabla de eventos: " . $conn->error);
}

$sql_create_table_orders = "
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    terms_accepted BOOLEAN NOT NULL,
    privacy_policy_accepted BOOLEAN NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    country VARCHAR(100) NOT NULL,
    province VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    zip_code VARCHAR(10) NOT NULL,
    address VARCHAR(255) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    card_holder VARCHAR(100),
    card_expiry_month VARCHAR(2),
    card_expiry_year VARCHAR(4),
    card_number VARCHAR(20),
    cvv VARCHAR(4),
    shipping_method VARCHAR(50) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);";

if ($conn->query($sql_create_table_orders) !== TRUE) {
    die("Error al crear la tabla de pedidos: " . $conn->error);
}

$sql_create_table_order_detail = "
CREATE TABLE IF NOT EXISTS order_detail (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    event_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (event_id) REFERENCES events(id)
);";

if ($conn->query($sql_create_table_order_detail) !== TRUE) {
    die("Error al crear la tabla de detalles pedido: " . $conn->error);
}

    
$sql_create_table_cart = "
CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (event_id) REFERENCES events(id)
);";
    
if ($conn->query($sql_create_table_cart) !== TRUE) {
    die("Error al crear la tabla de carrito: " . $conn->error);
}

$sql_create_table_country = "
CREATE TABLE IF NOT EXISTS countries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country_name VARCHAR(100) NOT NULL
);";

if ($conn->query($sql_create_table_country) !== TRUE) {
    die("Error al crear la tabla de paises: " . $conn->error);
}

$sql_create_table_provinces = "
CREATE TABLE IF NOT EXISTS provinces (
    id INT AUTO_INCREMENT PRIMARY KEY,
    province_name VARCHAR(100) NOT NULL,
    country_id INT, 
    FOREIGN KEY (country_id) REFERENCES countries(id)
);";

if ($conn->query($sql_create_table_provinces) !== TRUE) {
    die("Error al crear la tabla de provincias: " . $conn->error);
}


// Consulta para contar cuántos eventos existen en la tabla
$sql_count_events = "SELECT COUNT(*) AS total_events FROM events";
$result = $conn->query($sql_count_events);

if ($result) {
    $row = $result->fetch_assoc();
    $total_events = $row['total_events'];

    // Verificar si hay menos de 6 eventos
    if ($total_events < 6) {
        // Insertar los eventos predeterminados solo si hay menos de 6 eventos
        $sql_insert_events = "
        INSERT INTO events (name, email, event_name, description, event_date, event_time, image_url, city, location, style, price, number_of_tickets)
        VALUES
        ('Juan Pérez', 'juan@example.com', 'Concierto de Rock', 'Una noche inolvidable con las mejores bandas locales.', '2025-06-15', '20:00:00', 'https://dg9aaz8jl1ktt.cloudfront.net/uploaded_files/000/373/898/verkami_96a2aafefc1bb088f028e38424540650.jpg?1667978137', 'Almería', 'Auditorio Nacional', 'Rock', 45.00, 200),
        ('María López', 'maria@example.com', 'Feria de Tecnología', 'Exposición de los últimos avances tecnológicos.', '2025-07-10', '10:00:00', 'https://www.shutterstock.com/image-vector/vector-poster-banner-rock-festival-600nw-1211649412.jpg', 'Madrid', 'Centro de Convenciones', 'Rap', 25.00, 500),
        ('Carlos Gómez', 'carlos@example.com', 'Festival de Cine', 'Proyección de cortometrajes internacionales.', '2025-08-05', '18:00:00', 'https://i.pinimg.com/236x/a2/b0/c9/a2b0c97516575fa5363dc0e5a6f08f57.jpg', 'Barcelona', 'Cine Independiente', 'Pop', 30.00, 150),
        ('Ana Torres', 'ana@example.com', 'Conferencia de Marketing', 'Aprende de los expertos en marketing digital.', '2025-05-20', '09:00:00', 'https://previews.123rf.com/images/paseven/paseven2011/paseven201100047/158662131-afiche-para-un-concierto-de-m%C3%BAsica-en-vivo-con-una-guitarra-abstracta-brillante-y-letras-sobre-un.jpg', 'Valencia', 'Hotel Gran Vista', 'Flamenco', 60.00, 100),
        ('Luis Fernández', 'luis@example.com', 'Carrera 5K', 'Carrera familiar en el parque central.', '2025-09-12', '07:30:00', 'https://www.ritmo.es/Portals/0/EasyDNNnews/1275/RP201212_FOTO3.jpg', 'Sevilla', 'Parque Central', 'Heavy Metal', 15.00, 300),
        ('Carlos Gómez', 'carlos@example.com', 'Festival de Cine', 'Proyección de cortometrajes internacionales.', '2025-08-05', '18:00:00', 'https://i.pinimg.com/236x/a2/b0/c9/a2b0c97516575fa5363dc0e5a6f08f57.jpg', 'Barcelona', 'Cine Independiente', 'Pop', 30.00, 150);
        ";

        if ($conn->query($sql_insert_events) !== TRUE) {
            die("Error al insertar eventos predeterminados: " . $conn->error);
        }
    }
} else {
    die("Error al contar los eventos: " . $conn->error);
}


// Consulta para contar si hay paises y ciudades
$sql_count_country = "SELECT COUNT(*) AS total_countries FROM countries";
$result_country = $conn->query($sql_count_country);

$sql_count_city = "SELECT COUNT(*) AS total_provinces FROM provinces";
$result_city = $conn->query($sql_count_city);

if ($result) {
    $row = $result_country->fetch_assoc();
    $total_countries = $row['total_countries'];

    $row = $result_city->fetch_assoc();
    $total_provinces = $row['total_provinces'];

    // Verificar si hay menos de 6 eventos
    if ($total_countries == 0) {

        $sql_insert_countries = "INSERT INTO countries (country_name) VALUES('España'),('Portugal'),('Francia'),('Alemania'),('Italia')";

        if ($conn->query($sql_insert_countries) !== TRUE) {
            die("Error al insertar paises: " . $conn->error);
        }
    }
    if ($total_provinces == 0) {

        $sql_insert_cities = "INSERT INTO provinces (province_name, country_id) VALUES
        ('Madrid', 1), ('Barcelona', 1), ('Malaga', 1), ('Sevilla', 1), ('Almería', 1), ('Valencia', 1), ('Lugo', 1), ('Bilbao', 1), ('Oporto', 2),
        ('Lisboa', 2), ('Paris', 3), ('Lyon', 3), ('Berlin', 4), ('Munich', 4), ('Roma', 5), ('Milan', 5)";

        if ($conn->query($sql_insert_cities) !== TRUE) {
            die("Error al insertar provincias: " . $conn->error);
        }
    }
}