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

    function togglePayment() {
        divCreditCard.hidden = !radioCreditCard.checked;
        divPaypal.hidden = !radioPaypal.checked;
    }

    radioCreditCard.addEventListener("change", togglePayment);
    radioPaypal.addEventListener("change", togglePayment);

    // Funcionalidad selects de pais y provincia
    $('#country').change(function() {
        const countryId = this.value; 
        const selectedCountryName = $('#country option:selected').text();
        $('#country_name').val(selectedCountryName);
    
        const provinceSelect = $('#province');
        provinceSelect.empty();
    
        if (provincesByCountry[countryId]) {
            provinceSelect.prop('disabled', false);
            provinceSelect.append('<option value="" disabled selected>Select province</option>');
            provincesByCountry[countryId].forEach(province => {
                provinceSelect.append(`<option value="${province.id}">${province.province_name}</option>`);
            });
    
            provinceSelect.off('change').on('change', function() {
                $('#province_name').val($('#province option:selected').text());
            });
        } else {
            provinceSelect.prop('disabled', true);
            provinceSelect.append('<option value="" disabled selected>No provinces available</option>');
            $('#province_name').val('');
        }
    });

    // Funcionalidad boton pagar, para saber si abrir paypal o enviar formulario directo
    payButton.addEventListener("click", function(event) {
        if (radioPaypal.checked) {
            event.preventDefault(); // Evita el envío normal del formulario

            // Eliminar atributos required de los campos de la tarjeta de crédito al hacer clic en Pagar con PayPal
            creditCardFields.forEach(field => { field.removeAttribute("required"); });
 
            if (paymentForm.checkValidity()) {
                // Si es válido, abrir la ventana de PayPal
                window.open(paypalSimulacionURL, 'PayPal', 'width=600,height=400');
            } else {
                // Si no es válido, mostrar los errores
                paymentForm.reportValidity();
            }

        }
    });

    // Funcionalidad metodo de envio, sumar el coste
    $('input[name="forma-pago"]').change(function() {
        const shippingPrices = {
            'eticket': 1,
            'ticket-fisico': 3,
            'express-ticket-fisico': 5
        };

        const shippingPrice = shippingPrices[this.value] || 0;

        // Actualiza el texto del precio de envío
        $('.pago-resumen-container .d-flex.justify-content-between:has(span:contains("Shipping")) div').text(shippingPrice.toFixed(2) + ' €');

        // Recalcula y actualiza el total
        $('.pago-resumen-container .d-flex.justify-content-between:has(strong:contains("Total")) div strong')
            .text((cartTotals['total_carrito'] + cartTotals['total_quantity'] + shippingPrice).toFixed(2) + ' €');
    
    });

    // Llamar a togglePayment al cargar la página para establecer el estado inicial
    togglePayment();
});