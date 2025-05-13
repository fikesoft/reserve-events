<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/style/encuesta.css">
    <!-- Importar Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="font-family_encuesta d-flex flex-column min-vh-100">
    <!-- Encabezado -->
    <?php
    include "../static/header.php";
    ?>

    <div class="container justify-content-center align-items-center p-5 text-center flex-grow-1">
        <h1 class="display-4 mb-3">Thanks for your review!</h1>
        <p class="lead mb-4">We appreciate your feedback and will use it to improve our events.</p>
        <a href="../static/home.php" class="btn btn-back_home">Back to Home</a>
    </div>

    <!-- Footer -->
    <?php
    include '../static/footer.php';
    ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

