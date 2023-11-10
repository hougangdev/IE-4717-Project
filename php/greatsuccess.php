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
</head>
<body>

    <!-- Nav Bar -->
    <header class="header">
        <a href="../pages/home.php" class="logo">HAOCHI</a>

        <nav class="navbar">
            <a href="../pages/home.php">Home</a>
            <a href="../pages/about.html">About</a>
            <a href="../pages/menu.php">Menu</a>
            <?php if (!empty($_SESSION["user_id"])): ?>
            <a href="../pages/logout.php">Logout</a>
            <?php else: ?>
            <a href="../pages/login.php">Login</a>
            <?php endif; ?>
        </nav>
    </header>

    <!-- Hero Section -->
    <div class="hero">
        <div class="content-container">
            <h1>Order has been place! Check your email for receipts</h1>
            <!-- If Login, Order Now should lead to menu. Else lead to sign up. -->
            <button id="orderButton" onclick="location.href='../pages/menu.php';">Order Again!</button>


        </div>
        
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>enquiries@haochi.com</p>
        <p>123 Eatery Street, Singapore 888888</p>
        <p>&copy; 2023 HAOCHI Pte Ltd</p>
    </div>


</body>
</html>