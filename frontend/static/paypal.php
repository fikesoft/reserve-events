<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayPal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light min-vh-100 d-flex justify-content-center align-items-center">
    <div class="container col-md-4 p-4 bg-white rounded shadow">
        <h2 class="text-primary text-center mb-3">PayPal</h2>
        <form id="paypal-form">
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid">
                <button type="button" class="btn btn-primary" onclick="continuePayment()">Continuar</button>
            </div>
        </form>
    </div>
    <script>
        function continuePayment() {
            window.opener.document.getElementById('checkout-form').submit();
            window.close();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>