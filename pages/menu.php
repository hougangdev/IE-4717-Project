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
        <a href="#" class="logo">HAOCHI</a>

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

    <!-- Multi-Menu -->
    <div class="multimenu--container">
        <a href="menu--seafood.php" class="card-link">
            <div class="multimenu--card">
            <img src="../media/seafood.jpg" alt="Seafood Image">
            <p>Seafood</p>
        </div>
        </a>
        
        <a href="menu--meat.php" class="card-link">
            <div class="multimenu--card">
            <img src="../media/meat.jpg" alt="Meat Image">
            <p>Meat</p>
        </div>
        </a>
        <a href="menu--vegetarian.php" class="card-link">
            <div class="multimenu--card">
            <img src="../media/vegetarian.jpg" alt="Vegetarian Image">
            <p>Vegetarian</p>
        </div>
        </a>
        <a href="menu--halal.php" class="card-link">
            <div class="multimenu--card">
            <img src="../media/halal.jpg" alt="Halal Image">
            <p>Halal</p>
        </div>
        </a>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>enquiries@haochi.com</p>
        <p>123 Eatery Street, Singapore 888888</p>
        <p>&copy; 2023 HAOCHI Pte Ltd</p>
    </div>


</body>
</html>