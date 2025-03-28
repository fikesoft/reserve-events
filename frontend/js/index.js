const form = document.getElementById('dataForm');

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    const response = await fetch('http://localhost/reserve-events/backend/index.php', {
        method: 'POST',
        body: formData
    });

    const result = await response.text();  
    document.getElementById('response').innerText = result;
});
