document.addEventListener('DOMContentLoaded', function() {
    // Get all the increase and decrease buttons
    var decreaseButtons = document.querySelectorAll('.quantity-decrease');
    var increaseButtons = document.querySelectorAll('.quantity-increase');

    // Initialize shopping cart from session storage (or an empty array if not present)
    var cart = JSON.parse(sessionStorage.getItem('cart') || '[]');

    
    // Function to update the cart display
    function updateCartDisplay() {
        var cartDisplay = document.getElementById('cart-display');
        var cartTotalEl = document.getElementById('cart-total');
        var total = 0;

        cartDisplay.innerHTML = ''; // Clear the current cart display

        cart.forEach(function(item) {
            var itemElement = document.createElement('div');
            itemElement.innerHTML = `
                <h4>${item.productTitle}</h4>
                <p>Quantity: ${item.quantity}</p>
                <p>Price: $${(item.productPrice * item.quantity).toFixed(2)}</p>
            `;
            cartDisplay.appendChild(itemElement);
            total += item.productPrice * item.quantity;
        });

        cartTotalEl.textContent = total.toFixed(2);  // Update the total price
    }

    // Triggered when quantity changes
    function onQuantityChange(event, isIncrease) {
        var input = event.target.closest('.quantity-controls').querySelector('.quantity');
        var productTitle = event.target.closest('.menu-card').querySelector('.menu-product-title').textContent;
        var productPrice = parseFloat(event.target.closest('.menu-card').querySelector('.menu-product-price').textContent.replace('$', ''));

        if (isIncrease) {
            input.value = parseInt(input.value) + 1;
        } else if (input.value > 0) {
            input.value = parseInt(input.value) - 1;
        }

        // Check if product is already in cart
        var cartItem = cart.find(item => item.productTitle === productTitle);

        if (cartItem) {
            cartItem.quantity = parseInt(input.value);
        } else {
            cart.push({ productTitle: productTitle, productPrice: productPrice, quantity: parseInt(input.value) });
        }

        // Remove items with zero quantity from cart
        cart = cart.filter(item => item.quantity > 0);

        // Update the session storage
        sessionStorage.setItem('cart', JSON.stringify(cart));

        // Update the cart display
        updateCartDisplay();
    }
    

    decreaseButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            onQuantityChange(event, false);
        });
    });

    increaseButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            onQuantityChange(event, true);
        });
    });

    // Add the clear cart button event listener
    var clearCartButton = document.getElementById('clear-cart-button');
    clearCartButton.addEventListener('click', function() {
        // Reset the cart
        cart = [];

        // Update session storage
        sessionStorage.setItem('cart', JSON.stringify(cart));

        // Update the cart display
        updateCartDisplay();
    });

    document.getElementById('orderForm').addEventListener('submit', function(event) {
        // Check if cart is empty.
        var cart = JSON.parse(sessionStorage.getItem('cart') || '[]');
        if (cart.length === 0) {
            event.preventDefault(); // Prevent form submission
            alert('Your cart is empty! Please add some products before checking out.');
        }
        // If the cart is not empty, the form will be submitted
    });
    

    // Initial cart display update
    updateCartDisplay();
});
