<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Icons Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!--CSS-->
    <link rel="stylesheet" href="../assets/style/register.css">

    <link rel="stylesheet" href="../assets/style/footer.css">
    <link rel="stylesheet" href="../assets/style/header.css">

    <!-- Cargar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

</head>

<body>
    <!-- Encabezado -->
    <header class="d-flex justify-content-center justify-content-md-between p-3 flex-md-row flex-column">
        <div class="d-flex flex-md-row flex-column align-items-center gap-4">
            <img class="logo-header" src="../assets/img/logo.png" alt="Logo de la empresa">
            <nav class="d-flex flex-grow-1 justify-content-center justify-content-md-start">
                <ul class="d-flex gap-4 m-0 p-0 list-unstyled align-items-center justify-content-start">
                    <li><a href="index.html" class="nav-header">Home</a></li>
                    <li><a href="#Eventos" class="nav-header">Events</a></li>
                    <li><a href="#AboutUs" class="nav-header">About us</a></li>
                </ul>
            </nav>
        </div>
        
        <!-- Buscador e Iconos -->
        <div class="d-flex align-items-center gap-4 mt-3 mt-md-0 flex-md-row flex-column">
            <div class="d-flex align-items-center search-box">
                <input class="search-box-input" type="text" placeholder="Search...">
                <button class="search-box-button"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
            <div class="d-flex">
                <a href="carrito.html" class="icons mx-3"><i class="fa-solid fa-cart-shopping"></i></a>
                <a href="login.html" class="icons mx-3"><i class="fa-solid fa-user"></i></a>
            </div>
            
        </div>
    </header>

    <main class="mt-5 mb-5 d-flex align-items-center justify-content-center">
        <div class="container bg-white d-flex p-0 shadow-lg rounded-3"
            style="max-width: 800px; border: 1px solid #4D194D;">
    
            <div class="p-5" style="flex: 1;">
                <h1 class="text-center mr-4">CREATE ACCOUNT</h1>
                <form action="../../backend/controllers/register.php" method="POST">
                    
                    <?php
                    session_start();
                    $form_data = $_SESSION['form_data'] ?? [];
                    $errors = $_SESSION['error'] ?? '';
                    unset($_SESSION['form_data'], $_SESSION['error']); // Limpiar variables
                    ?>

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-user-pen"></i></span>
                            <input 
                            type="text" 
                            name="name"
                            class="form-control" 
                            id="name" required 
                            placeholder="Enter your name"
                            value="<?= htmlspecialchars($form_data['name'] ?? '') ?>">
                        </div> 
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                            <input 
                            type="email" 
                            class="form-control"
                            name="email" 
                            id="email" required 
                            placeholder="Enter your email"
                            value="<?= htmlspecialchars($form_data['email'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input 
                            type="password" 
                            class="form-control" 
                            id="password" 
                            required 
                            placeholder="Create a password"
                            name="password">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input 
                            type="password" 
                            class="form-control" 
                            id="password" required 
                            placeholder="Confirm your password"
                            name="confirm_password">
                        </div>
                    </div>

                    <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger"><?= $errors ?></div>
                    <?php endif; ?>
                    
                    <button type="submit" class="btn btn-primary w-100 mb-3">Create an account</button>
                    <div class="text-center">
                        <a class="login-btn" href="#">Log in</a>
                    </div>
                </form>
            </div>
    
            <div class="position-relative d-flex" style="flex: 1;"> 
                <img src="../assets/img/concierto-registro.jpg" class="img-fluid image-container w-100 h-100" alt="Imagen de fondo" 
                style="object-fit: cover; border-top-right-radius: 5px; border-bottom-right-radius: 5px;">
                <div class="position-absolute text-white text-center image-container" style="top: 20%; left: 50%; transform: translate(-50%, -50%); width: 100%;">
                  <h1 class="display-5">Be part of us</h1>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="container-fluid p-5">
        <div class="d-flex flex-column align-items-center">
            <div class="row">
                <!-- Menú de navegación -->
                <nav class=" col-12 col-md-6 mt-3">    
                    <ul class="list-unstyled">
                        <li><a href="#" class="nav-footer">Home</a></li>
                        <li><a href="#" class="nav-footer">Events</a></li>
                        <li><a href="#" class="nav-footer">About us</a></li>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>