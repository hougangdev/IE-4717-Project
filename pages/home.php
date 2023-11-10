<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HAOCHI - Food Catering</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var typedText = document.getElementById('typedText');
            var textArray = ['At Your Doorstep.', 'In Seconds', 'Wherever You Are'];
            var typingDelay = 100; // Time delay between each character typing in milliseconds
            var erasingDelay = 50; // Time delay between each character erasing in milliseconds
            var nextTextDelay = 1000; // Time delay before typing next sentence in milliseconds
            var textArrayIndex = 0;
            var charIndex = 0;
        
            function type() {
                if (charIndex < textArray[textArrayIndex].length) {
                    typedText.textContent += textArray[textArrayIndex].charAt(charIndex);
                    charIndex++;
                    setTimeout(type, typingDelay);
                } else {
                    // Pause at end of sentence
                    setTimeout(erase, nextTextDelay);
                }
            }
        
            function erase() {
                if (charIndex > 0) {
                    typedText.textContent = textArray[textArrayIndex].substring(0, charIndex - 1);
                    charIndex--;
                    setTimeout(erase, erasingDelay);
                } else {
                    textArrayIndex++;
                    if (textArrayIndex >= textArray.length) textArrayIndex = 0;
                    setTimeout(type, typingDelay + 1100);
                }
            }
        
            // Start the typing effect once the page has loaded
            setTimeout(type, nextTextDelay + 250);
        });
        
    </script>
</head>
<body>

    <!-- Nav Bar -->
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
        </nav>
    </header>

    <!-- Hero Section -->
    <div class="hero">
        <div class="content-container">
            <h1>HAOCHI</h1>
            <div class="typing-container">
                <span class="foodText">Food</span> <span id="typedText"></span>
            </div>
            <div id="typedText"></div>

            <!-- If Login, Order Now should lead to menu. Else lead to sign up. -->
            <button id="orderButton">Order Now!</button>
            
            <script>
                // Function to check if the user is logged in
                function checkLoginStatus() {
                    const loginCookie = document.cookie.split('; ').find(cookie => cookie.startsWith('login_status=1'));
                    if (loginCookie) {
                    // User is logged in, redirect to the menu page
                    window.location.href = '../pages/menu.php'; 
                    } else {
                    // User is not logged in, redirect to the signup page
                    alert("Please log in first!")
                    window.location.href = '../pages/login.php'; 
                    }
                }

                // Get the button element
                const orderButton = document.getElementById('orderButton');

                // Add a click event listener to the button
                orderButton.addEventListener('click', function() {
                    checkLoginStatus();
                });
            </script>
        </div>
        
    </div>

    <!-- Gallery -->
    <script src="../js/autoscroll.js"></script>
    <div class="gallery">
        <a href="../pages/menu--seafood.php" class="gallery-item"><img src="../media/seafood.jpg" alt="Seafood"></a>
        <a href="../pages/menu--meat.php" class="gallery-item"><img src="../media/meat.jpg" alt="Meat"></a>
        <a href="../pages/menu--vegetarian.php" class="gallery-item"><img src="../media/vegetarian.jpg" alt="Vegetarian"></a>
        <!-- Add three more items -->
        <a href="../pages/menu--halal.php" class="gallery-item"><img src="../media/halal.jpg" alt="Vegan"></a>
        <a href="#desserts" class="gallery-item"><img src="../media/meat.jpg" alt="Desserts"></a>
        <a href="#beverages" class="gallery-item"><img src="../media/vegetarian.jpg" alt="Beverages"></a>
    </div>


    <!-- Footer -->
    <div class="footer">
        <p>enquiries@haochi.com</p>
        <p>123 Eatery Street, Singapore 888888</p>
        <p>&copy; 2023 HAOCHI Pte Ltd</p>
    </div>


</body>
</html>