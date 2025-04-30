<?php
session_start();
$editing = false;
$eventData = [];

if (isset($_GET['edit'])) {
    $editing = true;
    $eventData = $_SESSION['edit_event'] ?? [];
    unset($_SESSION['edit_event']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add your event</title>
    
    
    <!-- Importar Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/style/add_your_event.css">
    <!-- Cargar Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


</head>

<body>
    <!-- Encabezado -->
    <?php include 'header.php'; ?>

    <!-- Página principal -->
    <main class="container-fluid p-0 d-flex font-family_addYourEvent mb-3">
        <div class="container-fluid d-flex flex-column align-items-center justify-content-center px-3 px-md-0">

            <!-- Container con el título -->
            <div class="d-flex align-items-center justify-content-center p-3 p-md-5">
                <h1>ADD YOUR EVENT</h1>
            </div>

            <!-- Formulario -->
            <div class="d-flex justify-content-center align-items-center w-100 bg_addYourEvent">
                <form class="col-12 col-md-8 col-lg-6 p-5 shadow bg-white mt-3 mb-3 rounded-3 custom-form_addYourEvent" action="<?= $editing ? '../../backend/controllers/update_event.php' : '../../backend/controllers/crear_evento.php' ?>" method="POST">

                    <?php if ($editing): ?>
                        <input type="hidden" name="event_id" value="<?= htmlspecialchars($eventData['id'] ?? '') ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-user-pen"></i></span>
                            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($eventData['name'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($eventData['email'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="eventName" class="form-label">Event name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-ticket"></i></span>
                            <input type="text" class="form-control" id="eventName" name="eventName" value="<?= htmlspecialchars($eventData['event_name'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-pen-to-square"></i></span>
                            <textarea class="form-control auto-expand" id="description" name="description" rows="3" required><?= htmlspecialchars($eventData['description'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-calendar"></i></span>
                            <input type="date" class="form-control" id="date" name="date" value="<?= htmlspecialchars($eventData['event_date'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="time" class="form-label">Time</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-clock"></i></span>
                            <input type="time" class="form-control" id="time" name="time" value="<?= htmlspecialchars($eventData['event_time'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image URL</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-file-image"></i></span>
                            <input type="text" class="form-control" id="image" name="image" value="<?= htmlspecialchars($eventData['image_url'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-city"></i></span>
                            <input type="text" class="form-control" id="city" name="city" value="<?= htmlspecialchars($eventData['city'] ?? '') ?>" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-map-location"></i></span>
                            <input type="text" class="form-control" id="location" name="location" value="<?= htmlspecialchars($eventData['location'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="musicalStyle" class="form-label">Musical Style</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-music"></i></span>
                            <input type="text" class="form-control" id="musicalStyle" name="musicalStyle" value="<?= htmlspecialchars($eventData['style'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-money-check-dollar"></i></span>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= htmlspecialchars($eventData['price'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="number_tickets" class="form-label">Number of tickets</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-ticket-simple"></i></span>
                            <input type="number" class="form-control" id="number_tickets" name="number_tickets" value="<?= htmlspecialchars($eventData['number_of_tickets'] ?? '') ?>" required>
                        </div>
                    </div>
                    <!-- Botón enviar formulario -->
                    <button type="submit" class="button_addYourEvent btn w-100 mt-3">
                        <i class="fa-solid fa-paper-plane me-2"></i> Submit
                    </button>
                </form>

            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>