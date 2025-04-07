<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!--CSS Header -->
    <link rel="stylesheet" href="../assets/style/header.css">
    <!-- CSS Footer -->
    <link rel="stylesheet" href="../assets/style/footer.css">
    <!-- CSS Login -->
    <link rel="stylesheet" href="../assets/style/login.css">
    <!-- Importar Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <!-- Página principal -->
    <main class="d-flex align-items-center justify-content-center font-family_login min-vh-100">
        <div class="container d-flex justify-content-center align-items-center mt-5 mb-5">
            <div class="row g-0 align-items-center rounded-3 shadow w-100 border-custom_login">
                <!-- Columna Izquierda: Formulario -->
                <div class="col-md-6 d-flex p-5">
                    <div class="w-100 d-flex flex-column justify-content-center">
                        <h1 class="text-center mb-5">SIGN IN</h1>
                        <form class="font-size_login" action="../../backend/controllers/login.php" method="POST">

                            <?php
                            session_start();
                            $form_data = $_SESSION['form_data'] ?? [];
                            $errors = $_SESSION['error'] ?? '';
                            unset($_SESSION['form_data'], $_SESSION['error']); // Limpiar variables
                            ?>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                    <input 
                                    type="email" 
                                    class="form-control" 
                                    id="email"
                                    name="email" 
                                    value="<?= htmlspecialchars($_SESSION['form_data']['email'] ?? '') ?>" 
                                    required>
                                </div> 
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                    <input 
                                    type="password" 
                                    class="form-control" 
                                    id="password" 
                                    name="password" 
                                    required>
                                </div>
                            </div>

                            <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger"><?= $errors ?></div>
                            <?php endif; ?>

                            <!-- Checkbox "Recuérdame" -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">Remember Me</label>
                            </div>

                            <button type="submit" class="button_login btn w-100 mt-3">Sign in</button>    
                        </form>

                        <!-- Enlace a olvidé contraseña -->
                        <div class="text-center mt-3">
                            <a href="#" class="forgot-password">Forgot pasword?</a>
                        </div>
                        
                        <!-- Enlace para registro -->
                        <div class="text-center mt-3">
                            <p class="font-size_login">¿New in <strong>Random Events?</strong> <a href="registro.html" class="register-link">Sign up</a></p>
                        </div>
                    </div>
                </div>
    
                <!-- Columna Derecha: Imagen -->
                <div class="col-md-6 d-flex d-none d-md-block"> <!-- En pantallas pequeñas no aparece la imagen -->
                    <img src="../assets/img/Foto_Login.png" alt="Imagen Login" class="img-fluid w-100 rounded-end-3">
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
                    <ul class=" list-unstyled">
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