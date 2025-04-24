document.addEventListener("DOMContentLoaded", function() {
    const radioCreditCard = document.getElementById("credit-card");
    const radioPaypal = document.getElementById("paypal");
    const divCreditCard = document.getElementById("div-credit-card");
    const divPaypal = document.getElementById("div-paypal");
    const payButton = document.querySelector(".pago-button-pagar");
    const paymentForm = document.querySelector("form");
    const paypalSimulacionURL = 'paypal.php';

    // Array con los IDs de los campos de la tarjeta de crédito
    const creditCardFieldsIds = ["card-holder", "month-date-card", "year-date-card", "pago-card-number", "pago-cvv"];
    const creditCardFields = creditCardFieldsIds.map(id => document.getElementById(id));

    function togglePayment(){
        if (radioCreditCard.checked){
            divCreditCard.removeAttribute("hidden");
            divPaypal.setAttribute("hidden", true);
        }else if (radioPaypal.checked) {
            divCreditCard.setAttribute("hidden", true);
            divPaypal.removeAttribute("hidden");
        }
        
    }

    radioCreditCard.addEventListener("change", togglePayment);
    radioPaypal.addEventListener("change", togglePayment);

    payButton.addEventListener("click", function(event) {
        if (radioPaypal.checked) {
            event.preventDefault(); // Evita el envío normal del formulario

            // Eliminar atributos required de los campos de la tarjeta de crédito al hacer clic en Pagar con PayPal
            creditCardFields.forEach(field => {
                field.removeAttribute("required");
            });
 
            // Abrir la ventana de PayPal (la validación se hará en el backend)
            if (paymentForm.checkValidity()) {
                // Si es válido, abrir la ventana de PayPal
                const paypalWindow = window.open(paypalSimulacionURL, 'PayPal', 'width=600,height=400');
            } else {
                // Si no es válido, mostrar los errores
                paymentForm.reportValidity();
            }

        }
    });

    // Llamar a togglePayment al cargar la página para establecer el estado inicial
    togglePayment();
});