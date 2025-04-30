<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation </title>

    <style>
        .container { max-width: 600px; margin: 20px auto; background-color: #fff; }
        h1, h2 { color: #B44CB4; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; margin-bottom: 1rem; background-color: transparent; }
        th, td { padding: .75rem; vertical-align: top; border-top: 1px solid #dee2e6; text-align: left; }
        thead th { vertical-align: bottom; border-bottom: 2px solid #dee2e6; background-color: #4d194d; color: white }
        .info { margin: 2rem; padding: 1rem; border: 1px solid #ced4da; border-radius: .25rem; }
    </style>
    
</head>
<body>
    <div class="container">
        <h1>Hello!</h1>
        <p>Thank you for your order #{order_id} at Random Events.</p> 
        <h2>Order Details:</h2>
        <table>
            <thead>
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
        <p><strong>Subtotal: {subtotal_cart} € </strong></p>
        <p>Taxes (10%) included : {taxes} €</p>
        <p>Management Fees: {management_fees} €</p>
        <p>Shipping: {shipping} €</p>
        <p><strong>Total: {total_cart} € </strong></p>

        <div class="info">
            <h2>Shipping Address:</h2>
            <p><strong>Country:</strong> {country}</p>
            <p><strong>Province:</strong> {province}</p>
            <p><strong>City:</strong> {city}</p>
            <p><strong>Postal Code:</strong> {zip_code}</p>
            <p><strong>Address:</strong> {address}</p>
        </div>

        <div class="info">
            <h2>Payment Information:</h2>
            <p><strong>Payment Method:</strong> {payment_method}</p>
            <p><strong>Shipping Method:</strong> {shipping_method}</p>
        </div>

        <p>Thank you for your purchase.</p>
        <p>Best regards,<br>The Random Events Team</p>
    </div>
</body>
</html>