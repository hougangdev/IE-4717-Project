<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halal Menu</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

    <!-- Navbar -->
    <header class="header">
        <a href="home.php" class="logo">HAOCHI</a>

        <nav class="navbar">
            <a href="home.php">Home</a>
            <a href="about.html">About</a>
            <a href="menu.php">Menu</a>
            <?php if (!empty($_SESSION["user_id"])): ?>
            <a href="logout.php">Logout</a>
            <?php else: ?>
            <a href="login.php">Login</a>
            <?php endif; ?>
            <!-- Cart Button -->
            <div class="cart-dropdown-button-container">
                <button id="cart-button">Cart</button>
                <div id="cart-dropdown" class="cart-dropdown-content">
                    <div id="dropdown-cart-items">
                    <section class="shopping-cart">
                        <h2>Your Cart</h2>
                        <div id="cart-display"></div>
                        <p>Total: $<span id="cart-total">0.00</span></p>
                    </section>
                    </div>
                    <button id="checkout-button" type="submit" form="orderForm">Checkout</button>
                    <button id="clear-cart-button">Clear</button>
                    <script>
                    // Function to clear the cart from session storage and update the UI
                    function clearCart() {
                        sessionStorage.removeItem('cart'); // Clear the cart from session storage
                        document.getElementById('cart-display').innerHTML = ''; // Clear the cart display
                        document.getElementById('cart-total').innerText = '0.00'; // Reset the total to $0.00
                    }
                    
                    // Add click event listener to the "Clear Cart" button
                    document.getElementById('clear-cart-button').addEventListener('click', clearCart);
                    </script>
                </div>
            </div>
        </nav>
    </header>

    <!-- Halal Menu -->
    <form action="../php/checkout.php" method="POST" id="orderForm">
        <section class="menu-section">
            <h2 class="menu-title">Halal Menu</h2>
            <div class="menu-container">
            
     
                <!-- Card for Halal Product 1 -->
                <div class="menu-card">
                    <img src="../media/halal.jpg" alt="Halal Product 1 Image" class="menu-image">
                    <h3 class="menu-product-title">Halal Product 1</h3>
                    <p class="menu-product-description">Description for Halal Product 1</p>
                    <p class="menu-product-price">$10.70</p>
                    <div class="quantity-controls">
                        <!-- Quantity input for the user to choose how many products they want -->
                        <button type="button" class="quantity-decrease">-</button>
                        <!-- The quantity input field allows the user to manually specify the quantity -->
                        <input type="number" name="quantity[]" class="quantity" value="0" min="0">
                        <button type="button" class="quantity-increase">+</button>
                    </div>
                    <!-- Hidden fields to submit data that the user does not enter manually -->
                    <input type="hidden" name="product_id[]" value="10"> <!-- Unique Product ID -->
                    <input type="hidden" name="price[]" value="10.70"> <!-- Product Price -->
                </div>


                <!-- Card for Halal Product 2 -->
                <div class="menu-card">
                    <img src="../media/halal.jpg" alt="Halal Product 2 Image" class="menu-image">
                    <h3 class="menu-product-title">Halal Product 2</h3>
                    <p class="menu-product-description">Description for Halal Product 2</p>
                    <p class="menu-product-price">$9.50</p>
                    <div class="quantity-controls">
                        <!-- Quantity input for the user to choose how many products they want -->
                        <button type="button" class="quantity-decrease">-</button>
                        <!-- The quantity input field allows the user to manually specify the quantity -->
                        <input type="number" name="quantity[]" class="quantity" value="0" min="0">
                        <button type="button" class="quantity-increase">+</button>
                    </div>
                    <!-- Hidden fields to submit data that the user does not enter manually -->
                    <input type="hidden" name="product_id[]" value="11"> <!-- Unique Product ID -->
                    <input type="hidden" name="price[]" value="9.50"> <!-- Product Price -->
                </div>


                <!-- Card for Halal Product 3 -->
                <div class="menu-card">
                    <img src="../media/halal.jpg" alt="Halal Product 3 Image" class="menu-image">
                    <h3 class="menu-product-title">Halal Product 3</h3>
                    <p class="menu-product-description">Description for Halal Product 3</p>
                    <p class="menu-product-price">$9.75</p>
                    <div class="quantity-controls">
                        <!-- Quantity input for the user to choose how many products they want -->
                        <button type="button" class="quantity-decrease">-</button>
                        <!-- The quantity input field allows the user to manually specify the quantity -->
                        <input type="number" name="quantity[]" class="quantity" value="0" min="0">
                        <button type="button" class="quantity-increase">+</button>
                    </div>
                    <!-- Hidden fields to submit data that the user does not enter manually -->
                    <input type="hidden" name="product_id[]" value="12"> <!-- Unique Product ID -->
                    <input type="hidden" name="price[]" value="9.75"> <!-- Product Price -->
                </div>
                

            </div>

            <div class="checkout-button-container">
                <button type="submit" class="checkout-button">Checkout</button>
            </div>
        </section>
    </form>
    <!-- Footer -->
    <div class="footer">
        <p>enquiries@haochi.com</p>
        <p>123 Eatery Street, Singapore 888888</p>
        <p>&copy; 2023 HAOCHI Pte Ltd</p>
    </div>
    <script src="../js/card.js"></script>
    <script>
        document.getElementById('cart-button').addEventListener('click', function() {
            var cartDropdown = document.getElementById('cart-dropdown');
            cartDropdown.style.display = cartDropdown.style.display === 'block' ? 'none' : 'block';
        });

        document.getElementById('orderForm').addEventListener('submit', function(event) {
            let cart = JSON.parse(sessionStorage.getItem('cart') || '[]');
            if (cart.length === 0) {
                alert("Your cart is empty. Please add some products before checking out.");
                event.preventDefault(); // Prevent form from submitting
                return false;
            }
        });

    </script>
</body>
</html>


