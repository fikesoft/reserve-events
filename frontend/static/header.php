<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    <link rel="stylesheet" href="../assets/style/header.css">
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
                    <li><a href="about-us.php" class="nav-header">About us</a></li>
                </ul>
            </nav>
        </div>

        <!-- Buscador e Iconos -->
        <div class="d-flex align-items-center gap-4 mt-3 mt-md-0 flex-md-row flex-column">
            <div class="d-flex align-items-center search-box">
                <!-- Buscador -->
                <form action="/frontend/static/buscador.php" method="GET">
                    <input class="search-box-input" type="text" name="query" placeholder="Search...">
                    <button class="search-box-button">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>

            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="cart.php" class="icons mx-3" aria-label="Ver carrito">
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

</body>

</html>