<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!--CSS Header -->
    <link rel="stylesheet" href="../assets/style/header.css">
    <!-- CSS Footer -->
    <link rel="stylesheet" href="../assets/style/footer.css">
    <!-- CSS Login -->
    <link rel="stylesheet" href="../assets/style/register.css">

    <!-- Importar Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Cargar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <!-- Botón para cerrar y volver al Home -->
    <a href="home.php" class="btn-close position-absolute top-0 end-0 m-3" aria-label="Close"></a>

    <!-- Página principal -->
    <main class="d-flex align-items-center justify-content-center font-family_register mt-5 mb-5 min-vh-100">
        <div class="container d-flex justify-content-center align-items-center">
            <div class="row g-0 m-0 p-0 align-items-stretch rounded-3 shadow w-100 h-100 border-custom_register">
                <!-- Columna Izquierda: Formulario -->
                <div class="col-md-6 d-flex p-5">
                    <div class="w-100 d-flex flex-column justify-content-center">
                        <h1 class="text-center mb-3">CREATE AN ACCOUNT</h1>
                        <form class="font-size_register" action="../../backend/controllers/register.php" method="POST">

                            <?php
                            session_start();
                            $form_data = $_SESSION['form_data'] ?? [];
                            $errors = $_SESSION['error'] ?? '';
                            unset($_SESSION['form_data'], $_SESSION['error']); // Limpiar variables
                            ?>

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-user-pen"></i></span>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="name"
                                        name="name"
                                        required
                                        placeholder="Enter your name"
                                        value="<?= htmlspecialchars($form_data['name'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                    <input
                                        type="email"
                                        class="form-control"
                                        id="email"
                                        name="email"
                                        required
                                        placeholder="Enter your email"
                                        value="<?= htmlspecialchars($form_data['email'] ?? '') ?>">
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
                                        required
                                        placeholder="Create a password">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                    <input
                                        type="password"
                                        class="form-control"
                                        id="confirm_password"
                                        name="confirm_password"
                                        required
                                        placeholder="Confirm your password">
                                </div>
                            </div>

                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger"><?= $errors ?></div>
                            <?php endif; ?>

                            <button type="submit" class="button_register btn w-100 mt-3">Create an account</button>
                        </form>

                        <!-- Botón al login -->
                        <div class="text-center mt-3">
                            <p class="font-size_register">Have an account? <a href="login.php" class="login-link">Sign in</a></p>
                        </div>

                    </div>
                </div>

                <!-- Columna Derecha: Imagen -->
                <div class="col-md-6 d-flex d-none d-md-block"> <!-- En pantallas pequeñas no aparece la imagen -->
                    <img src="../assets/img/Foto_Register.png" alt="Imagen Register" class="img-fluid w-100 h-100 rounded-end img_register">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>