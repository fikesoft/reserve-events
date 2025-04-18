
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style/about-us-page.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/style/header.css">
    <link rel="stylesheet" href="../assets/style/footer.css">

    <title>About Us</title>
</head>
<body>
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
                                <li><hr class="dropdown-divider"></li>
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
    <div class="d-flex flex-column align-items-center gap-5 text-center p-2 customContainer mt-5">
        <div>
            <h1 class="headerAboutUs">THIS IS RANDOM</h1>
        </div>
        <div>
            <p  style="max-width: 500px;"> We’ve always believed that an event can change lives. At Random Events, we’ve built a 
                platform that lets fans experience shows they love effortlessly and without hassle.</p>
        </div>
        <div class="d-flex flex-column flex-lg-row align-items-center gap-4">
            <div class="d-flex flex-column gap-4 text-start" style=" max-width: 600px ">
                <h2 class="display-3">Going out invigorates us.</h2>
                <div class="d-flex flex-column gap-4">
                    <p>Whether you’re into intimate basement gigs, energetic club nights, sprawling festivals, 
                        wild raves, comedy shows, or dazzling drag cabarets, live events are where we forge 
                        unforgettable memories, discover our communities, and explore the hidden corners of our cities.</p>
                    <p>We understand the significance of these moments, which is why we’ve created an app 
                        that makes it effortless to dive into the events you love.</p>
                    <p>Since 2025, Random Events has been revolutionizing the ticketing experience for 
                        fans, artists, and venues—removing barriers to a great time and fostering a fairer, more inclusive industry.</p>
                </div>  
            </div>
            <div class="d-flex justify-content-center">
                <img 
                    class="img-fluid rounded-3" 
                    src="../assets/img/aboutUs-img.png" 
                    alt="about-us-ER" 
                    style= "max-width: 100%; height: auto" 
                />
            </div>
        </div>
    </div>
    <footer class="container-fluid p-5">
        <div class="d-flex flex-column align-items-center">
            <div class="row">
                <!-- Menú de navegación -->
                <nav class=" col-12 col-md-6 mt-3">    
                    <ul class="list-unstyled">
                        <li><a href="home.php" class="nav-footer">Home</a></li>
                        <li><a href="catalog-events.html" class="nav-footer">Events</a></li>
                        <li><a href="about-us.html" class="nav-footer">About us</a></li>
                    </ul>
                </nav>
            
                <!-- Información de contacto -->
                <div class="footer-contact col-12 col-md-6 mt-3">
                    <p class="text-nowrap m-1"><i class="fa-solid fa-phone me-2"></i> +34 123 456 789</p>
                    <p class="text-nowrap m-1"><i class="fa-solid fa-envelope me-2"></i> contacto@empresa.com</p>
                    <p class="text-nowrap m-1"><i class="fa-solid fa-map-marker-alt me-2"></i> Calle Falsa 123, Madrid, España</p>
                </div>
            </div>
        </div>

            <!-- Redes Sociales -->
            <div class="d-flex justify-content-center align-items-center gap-3 mt-3 col-12">
                <a href="#" class="footer-social"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="footer-social"><i class="fa-brands fa-twitter"></i></a>
                <a href="#" class="footer-social"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="footer-social"><i class="fa-brands fa-linkedin"></i></a>
            </div>
        
    
        <!-- Derechos de autor -->
        <div class="footer-bottom text-center pt-4 col-12">
            <p>&copy; 2025 Random Events. All rights reserved.</p>
        </div>
        
    </footer>

</body>
</html>