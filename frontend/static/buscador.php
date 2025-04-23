<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Estilos Header-->
    <link rel="stylesheet" href="../assets/style/header.css">
    <!-- Estilos footer-->
    <link rel="stylesheet" href="../assets/style/footer.css">
    <!-- Cargar Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Cargar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <!-- Encabezado -->
    <header class="d-flex justify-content-center justify-content-md-between p-3 flex-md-row flex-column">
        <div class="d-flex flex-md-row flex-column align-items-center gap-4">
            <img class="logo-header" src="../assets/img/logo.png" alt="Logo de la empresa">
            <nav class="d-flex flex-grow-1 justify-content-center justify-content-md-start">
                <ul class="d-flex gap-4 m-0 p-0 list-unstyled align-items-center justify-content-start">
                    <li><a href="home.php" class="nav-header">Home</a></li>
                    <li><a href="catalog-events.php" class="nav-header">Events</a></li>
                    <li><a href="about-us.html" class="nav-header">About us</a></li>
                </ul>
            </nav>
        </div>

        <!-- Buscador e Iconos -->
        <div class="d-flex align-items-center gap-4 mt-3 mt-md-0 flex-md-row flex-column">
            <div class="d-flex align-items-center search-box">
                <!-- Buscador -->
                <form action="../../backend/controllers/buscador.php" method="GET">
                    <input class="search-box-input" type="text" name="query" placeholder="Search...">
                    <button class="search-box-button">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>

            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="cart.html" class="icons mx-3" aria-label="Ver carrito">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>

                <?php if (isset($_SESSION['user_id'])): ?>

                    <!-- Menú desplegable de usuario -->
                    <div class="dropdown">
                        <a class="btn dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= htmlspecialchars($_SESSION['user_name']) ?>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <?php if ($_SESSION["user_role"] === "admin"): ?>
                                <li>
                                    <span class="dropdown-item-text">
                                        <span class="badge badge-custom">Admin</span>
                                    </span>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            <?php endif; ?>
                            <li><a class="dropdown-item text-danger" href="../../backend/controllers/logout.php">Sign out</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <!-- Enlace al login -->
                    <a href="login.php" class="icons" aria-label="Iniciar sesión">
                        <i class="fa-solid fa-user"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <?php
    session_start();
    // Incluir la conexión a la base de datos
    require_once '../../backend/config/database.php';

    //Obtener y filtrar la búsqueda
    if (isset($_GET['query'])) {
        $search_query = mysqli_real_escape_string($conn, $_GET['query']);
    } else {
        $search_query = '';
    }

    // Si la búsqueda está vacía, redirige al inicio
    if (empty($search_query)) {
        echo "Por favor ingrese un término de búsqueda.";
        exit;
    }

    // Consulta SQL para buscar eventos que coincidan con el término de búsqueda
    $sql_search_events = "
    SELECT * FROM events WHERE event_name LIKE ? OR description LIKE ?
    ";
    $stmt = $conn->prepare($sql_search_events);

    // Usamos % para permitir búsqueda parcial
    $search_term = "%" . $search_query . "%";

    // Vinculamos el parámetro de búsqueda
    $stmt->bind_param("ss", $search_term, $search_term);

    // Ejecutamos la consulta
    $stmt->execute();

    // Obtenemos los resultados
    $result = $stmt->get_result();

    // Verificar si se encontraron resultados
    if ($result->num_rows > 0) {
        echo "<h2>Resultados de búsqueda para: " . htmlspecialchars($search_query) . "</h2>";
        while ($row = $result->fetch_assoc()) {
    ?>

            <main class="mb-5">
                <div class="container mt-4">
                    <h1 class="text-left"><?= htmlspecialchars($row['event_name']) ?></h1>

                    <div class="row mt-4">
                        <!-- Columna de la imagen -->
                        <div class="col-md-4" style="position: relative;">
                            <img src="<?= $row['image_url'] ?>" class="img-fluid"
                                alt="Imagen del evento">
                            <div
                                style="background-color: black; border-radius: 40px; max-width: 25px; display: flex;padding: 7px; justify-content: center; align-items: center; height: 25px; position: absolute; top: 8px; left: 24px;">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M3.72692 1C2.22077 1 1 2.29358 1 3.88889C1 6.2963 3.27308 8.22222 6 10.6296C8.72769 8.22222 11 6.2963 11 3.88889C11 2.29358 9.77923 1 8.27231 1C7.32385 1 6.48846 1.51358 6 2.29197C5.75419 1.89622 5.41753 1.57076 5.02059 1.34514C4.62364 1.11952 4.17896 1.00089 3.72692 1Z"
                                        stroke="white" />
                                </svg>
                            </div>
                        </div>

                        <!-- Columna de las entradas -->
                        <div class="col-md-8" style="max-width: 600px;">
                            <div class="d-flex flex-column gap-3">


                                <div class="d-flex align-items-stretch border rounded">
                                    <div class="text-white text-center px-3 py-4 d-flex flex-column justify-content-center rounded-start"
                                        style="background-color:#4d194d;">
                                        <p class="mb-2 fw-bold"><?= date("d M", strtotime($row['event_date'])) ?></p>
                                        <p class="mb-2"><?= strtoupper(date("D", strtotime($row['event_date']))) ?></p>
                                        <p class="mb-0"><?= date("h:i A", strtotime($row['event_time'])) ?></p>
                                    </div>
                                    <div class="ms-3 w-100 d-flex flex-column justify-content-around">

                                        <div class="d-flex flex-column gap-2">
                                            <p class="fw-bold mb-1"><?= htmlspecialchars($row['event_name']) ?></p>
                                            <p class="mb-1"><?= htmlspecialchars($row['location']) ?></p>
                                        </div>
                                        <div class="d-flex justify-content-between ">
                                            <div class="d-flex flex-column gap-2">
                                                <div class="d-flex gap-2">
                                                    <img src="../assets/iconos/mapaa.svg" alt="icono del mapa">
                                                    <p class="mb-1 text-primary fw-bold"><?= htmlspecialchars($row['location']) ?></p>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <img src="../assets/iconos/entrada.svg" alt="">
                                                    <p class="mb-1 text-primary fw-bold">Class Normal</p>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column align-items-center gap-2 mx-2">
                                                <p class="mb-0"><?= htmlspecialchars($row['price']) ?>$/person</p>
                                                <div class="d-flex align-items-center justify-content-between rounded-pill px-3 py-1"
                                                    style="background-color: #4d194d; width: 120px;">
                                                    <button
                                                        class="btn p-0 border-0 text-white d-flex align-items-center justify-content-center"
                                                        style="background-color: transparent; width: 30px; height: 30px; font-size: 18px;">-</button>
                                                    <span class="text-white fs-6">0</span>
                                                    <button
                                                        class="btn p-0 border-0 text-white d-flex align-items-center justify-content-center"
                                                        style="background-color: transparent; width: 30px; height: 30px; font-size: 18px;">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-stretch border rounded">
                                    <div class="text-white text-center px-3 py-4 d-flex flex-column justify-content-center rounded-start"
                                        style="background-color:#b44cb4;">
                                        <p class="mb-2 fw-bold"><?= date("d M", strtotime($row['event_date'])) ?></p>
                                        <p class="mb-2"><?= strtoupper(date("D", strtotime($row['event_date']))) ?></p>
                                        <p class="mb-0"><?= date("h:i A", strtotime($row['event_time'])) ?></p>
                                    </div>
                                    <div class="ms-3 w-100 d-flex flex-column justify-content-around">

                                        <div class="d-flex flex-column gap-2">
                                            <p class="fw-bold mb-1"><?= htmlspecialchars($row['event_name']) ?></p>
                                            <p class="mb-1"><?= htmlspecialchars($row['location']) ?></p>
                                        </div>
                                        <div class="d-flex justify-content-between ">
                                            <div class="d-flex flex-column gap-2">
                                                <div class="d-flex gap-2">
                                                    <img src="../assets/iconos/mapaa.svg" alt="icono del mapa">
                                                    <p class="mb-1 text-primary fw-bold"><?= htmlspecialchars($row['location']) ?></p>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <img src="../assets/iconos/entrada.svg" alt="">
                                                    <p class="mb-1 text-primary fw-bold">Class Normal</p>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column align-items-center gap-2 mx-2">
                                                <p class="mb-0"><?= htmlspecialchars($row['price']) ?>$/person</p>
                                                <div class="d-flex align-items-center justify-content-between rounded-pill px-3 py-1"
                                                    style="background-color: #b44cb4; width: 120px;">
                                                    <button
                                                        class="btn p-0 border-0 text-white d-flex align-items-center justify-content-center"
                                                        style="background-color: transparent; width: 30px; height: 30px; font-size: 18px;">-</button>
                                                    <span class="text-white fs-6">0</span>
                                                    <button
                                                        class="btn p-0 border-0 text-white d-flex align-items-center justify-content-center"
                                                        style="background-color: transparent; width: 30px; height: 30px; font-size: 18px;">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-stretch border rounded">
                                    <div class="text-white text-center px-3 py-4 d-flex flex-column justify-content-center rounded-start"
                                        style="background-color:#f5a6f5;">
                                        <p class="mb-2 fw-bold"><?= date("d M", strtotime($row['event_date'])) ?></p>
                                        <p class="mb-2"><?= strtoupper(date("D", strtotime($row['event_date']))) ?></p>
                                        <p class="mb-0"><?= date("h:i A", strtotime($row['event_time'])) ?></p>
                                    </div>
                                    <div class="ms-3 w-100 d-flex flex-column justify-content-around">

                                        <div class="d-flex flex-column gap-2">
                                            <p class="fw-bold mb-1"><?= htmlspecialchars($row['event_name']) ?></p>
                                            <p class="mb-1"><?= htmlspecialchars($row['location']) ?></p>
                                        </div>
                                        <div class="d-flex justify-content-between ">
                                            <div class="d-flex flex-column gap-2">
                                                <div class="d-flex gap-2">
                                                    <img src="../assets/iconos/mapaa.svg" alt="icono del mapa">
                                                    <p class="mb-1 text-primary fw-bold"><?= htmlspecialchars($row['location']) ?></p>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <img src="../assets/iconos/entrada.svg" alt="">
                                                    <p class="mb-1 text-primary fw-bold">Class Normal</p>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column align-items-center gap-2 mx-2 ">
                                                <p class="mb-0"><?= htmlspecialchars($row['price']) ?>$/person</p>
                                                <div class="d-flex align-items-center justify-content-between rounded-pill px-3 py-1"
                                                    style="background-color: #f5a6f5; width: 120px;">
                                                    <button
                                                        class="btn p-0 border-0 text-white d-flex align-items-center justify-content-center"
                                                        style="background-color: transparent; width: 30px; height: 30px; font-size: 18px;">-</button>
                                                    <span class="text-white fs-6">0</span>
                                                    <button
                                                        class="btn p-0 border-0 text-white d-flex align-items-center justify-content-center"
                                                        style="background-color: transparent; width: 30px; height: 30px; font-size: 18px;">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div>
                            <p><?= htmlspecialchars($row['description']) ?></p>
                        </div>
                        <div class="d-flex justify-content-around mt-5">
                            <button class="border rounded p-3" style="background-color: white; border: 2px solid black !important; ">Go back</button>
                            <button class="border rounded p-3 text-white" style="background-color: #4d194d;">Añadir al carrito</button>
                        </div>

                    </div>
                </div>
            </main>

    <?php
        }
    } else {
        echo "No se encontraron eventos que coincidan con '$search_query'.";
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();

    ?>
</body>

</html>