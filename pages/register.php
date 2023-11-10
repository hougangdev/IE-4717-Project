
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database 
    $conn = new mysqli("localhost", "root", "", "haochi");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve user input
    $username = $_POST['registration_input_name'];
    $email = $_POST['registration_input_email'];
    $password = $_POST['registration_input_password'];
    $address = $_POST['registration_input_address'];
    $postal = $_POST['registration_input_postal'];

    // Check if username or email already exists
    $usernameCheckQuery = "SELECT * FROM customers WHERE username = ?";
    $emailCheckQuery = "SELECT * FROM customers WHERE email = ?";

    // Prepare and execute the username check
    $usernameCheckStmt = $conn->prepare($usernameCheckQuery);
    $usernameCheckStmt->bind_param("s", $username);
    $usernameCheckStmt->execute();
    $usernameResult = $usernameCheckStmt->get_result();
    $usernameCheckStmt->close();

    // Prepare and execute the email check
    $emailCheckStmt = $conn->prepare($emailCheckQuery);
    $emailCheckStmt->bind_param("s", $email);
    $emailCheckStmt->execute();
    $emailResult = $emailCheckStmt->get_result();
    $emailCheckStmt->close();

    // If username or email exists, show an error
    if ($usernameResult->num_rows > 0) {
        echo '<script>';
        echo 'alert("Username already exists. Please choose another one.");';
        echo 'window.location.href = "register.php";';
        echo '</script>';
        $conn->close();
        exit();
    } elseif ($emailResult->num_rows > 0) {
        echo '<script>';
        echo 'alert("Email already exists. Please choose another one.");';
        echo 'window.location.href = "register.php";';
        echo '</script>';
        $conn->close();
        exit();
    }
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert user data into the database
    $sql = "INSERT INTO customers (username, password, email, address, postal) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $hashed_password, $email, $address, $postal);

    if ($stmt->execute()) {
        // Registration successful
        echo '<script>';
        echo 'alert("Register successfully! Please log in.");';
        echo 'window.location.href = "login.php";';
        echo '</script>';
    } else {
        // Registration failed
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script defer src="../js/validate.js"></script>
</head>
<body>

    <!-- Navbar -->
    <header class="header">
        <a href="home.php" class="logo">HAOCHI</a>
        <nav class="navbar">
            <a href="home.php">Home</a>
            <a href="about.html">About</a>
            <a href="menu.php">Menu</a>
            <a href="login.php">Login</a>
        </nav>
    </header>

    <!-- Registration -->
    <div class="login-container">
        <div class="login-card">
            <h2>Registration</h2>
            <form action="<?= htmlentities($_SERVER['PHP_SELF']) ?>" method="post" id="form_user" data-id="register">
                <input type="text" name="type" value="register" hidden required>
                
                <!-- Username -->
                <div class="registration_item">
                    <label for="registration_name">Username</label>
                    <input class="user_input" type="text" name="registration_input_name" id="registration_input_name" required>
                    <span class="error" id="error_name"></span>
                </div>

                <!-- Email -->
                <div class="registration_item">
                    <label for="registration_email">E-mail</label>
                    <input class="user_input" type="email" name="registration_input_email" id="registration_input_email" required>
                    <span class="error" id="error_email"></span>
                </div>

                <!-- Password -->
                <div class="registration_item">
                    <label for="registration_password">Password</label>
                    <input class="user_input" type="password" name="registration_input_password" id="registration_input_password" minlength="8" required>
                    <span class="error" id="error_password"></span>
                </div>

                <!-- Address -->
                <div class="registration_item">
                    <label for="registration_address">Address</label>
                    <input class="user_input" type="text" name="registration_input_address" id="registration_input_address" required>
                    <span class="error" id="error_address"></span> 
                </div>

                <!-- Postal -->
                <div class="registration_item">
                    <label for="registration_postal">Postal</label>
                    <input class="user_input" type="text" name="registration_input_postal" id="registration_input_postal" required>
                    <span class="error" id="error_postal"></span>
                </div>

                <button type="submit" class="registration_button" id="registration_submit">Register</button>
            </form>
            <div>
                <p>
                Already have an account? 
                Click <a href="login.php">HERE</a> to login.
                </p>
            </div>
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
