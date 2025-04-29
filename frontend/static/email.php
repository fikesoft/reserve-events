<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation </title>

    <!-- Importar Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    

    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f8f9fa; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; background-color: #fff; border: 1px solid rgba(0,0,0,.125); border-radius: .25rem; }
        h1, h2 { color: #B44CB4; margin-top: 0; margin-bottom: .5rem; font-weight: 500; line-height: 1.2; }
        h1 { font-size: 2.5rem; }
        h2 { font-size: 2rem; }
        p { margin-top: 0; margin-bottom: 1rem; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; margin-bottom: 1rem; background-color: transparent; }
        th, td { padding: .75rem; vertical-align: top; border-top: 1px solid #dee2e6; text-align: left; }
        thead th { vertical-align: bottom; border-bottom: 2px solid #dee2e6; background-color: #e9ecef; }
        .font-weight-bold { font-weight: bold; }
        .info { margin-top: 1rem; padding: 1rem; border: 1px solid #ced4da; border-radius: .25rem; }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #f8f9fa;">
    <div class="container mx-auto border p-2">
        <h1>Hello!</h1>
        <p>Thank you for your order #{order_id} at Random Events.</p> 
        <h2>Order Details:</h2>
        <table class="w-100 mt-2 ">
            <thead class="thead-light">
                <tr>
                    <th>Event</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                {cart_items}
            </tbody>
        </table>
        <p class="font-weight-bold">Subtotal: {subtotal_cart} €</p>
        <p>Taxes (10%): {taxes} €</p>
        <p>Management Fees: {management_fees} €</p>
        <p>Shipping: {shipping} €</p>
        <p class="font-weight-bold">Total: {total_cart} €</p>

        <div class="info mt-2 p-1 border">
            <h2>Shipping Address:</h2>
            <p><strong class="font-weight-bold">Country:</strong> {country}</p>
            <p><strong class="font-weight-bold">Province:</strong> {province}</p>
            <p><strong class="font-weight-bold">City:</strong> {city}</p>
            <p><strong class="font-weight-bold">Postal Code:</strong> {zip_code}</p>
            <p><strong class="font-weight-bold">Address:</strong> {address}</p>
        </div>

        <div class="info mt-2 p-1 border">
            <h2>Payment Information:</h2>
            <p><strong class="font-weight-bold">Payment Method:</strong> {payment_method}</p>
            <p><strong class="font-weight-bold">Shipping Method:</strong> {shipping_method}</p>
        </div>

        <p>Thank you for your purchase.</p>
        <p>Best regards,<br>The Random Events Team</p>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>