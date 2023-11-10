<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
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
        </nav>
    </header>

    <!-- Login -->
    <div class="login-container">
        <div class="login-card">
            <h2>Login</h2>
            <form action="<?= htmlentities($_SERVER['PHP_SELF']) ?>" method="post">
                <input type="email" name="login_input_email" placeholder="Email" required>
                <input type="password" name="login_input_password" placeholder="Password" required minlength="8">
                <button type="submit">START NOW!</button>
                <input type="text" name="type" value="login" hidden required>
            </form>
            <div>
                <p>
                Don't have an account? 
                Click <a href="register.php">HERE</a> to register.
                </p>
            </div>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['type'] === 'login') {
                // Connect to the database 
                $conn = new mysqli("localhost", "root", "", "haochi");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Get user input
                $email = $_POST['login_input_email'];
                $password = $_POST['login_input_password'];

                // Query the database to retrieve the stored password for the provided email
                $sql = "SELECT customer_id, email, password FROM customers WHERE email = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->bind_result($id, $db_email, $db_password);
                $stmt->fetch();

                // Verify the password
                if (password_verify($password, $db_password)) {
                    // Password is correct
                    session_start();
                    $_SESSION['user_id'] = $id;
                    setcookie("login_status", "1", time() + 3600, "/"); // "1" indicates the user is logged in, and the cookie expires in 1 hour
                    $userIsLoggedIn = true;
                    echo "Login successful!";
                    
                    // Redirect the user to their dashboard or another page
                    header("Location: home.php");
                    exit();
                } else {
                    // Password is incorrect
                    echo "Login failed. Please check your credentials.";
                }

                $stmt->close();
                $conn->close();
            }
            ?>
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
