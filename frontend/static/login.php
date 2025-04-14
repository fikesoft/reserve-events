<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- CSS Login -->
    <link rel="stylesheet" href="../assets/style/login.css">
    <!-- Importar Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Cargar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>
    <!-- Botón para cerrar y volver a la página anterior -->
    <button onclick="window.history.back()" class="btn-close position-absolute top-0 end-0 m-3" aria-label="Close"></button>
    
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
                            <p class="font-size_login">¿New in <strong>Random Events?</strong> <a href="register.php" class="register-link">Sign up</a></p>
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
    
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>