document.getElementById('checkout-button').addEventListener('click', function() {
    var cart = JSON.parse(localStorage.getItem('cart') || '[]');
    fetch('../php/checkout.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ cart: cart })
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        // Handle the response from the server here
    });
});

