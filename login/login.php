<section class="login">
    <form action="<?= htmlentities($_SERVER['PHP_SELF']) ?>" method="post" class="form__user" id="form__user" data-id="login">

    <h1 class = "user_title">Login</h1>

    <input type="text" name="type" value="login" hidden required>

     <!--Email-->
     <div class ="login_item">
            <div class= "user_field">
                <label for="login_email">
                    <span>E-mail</span>
                </label>
            </div>
            <div class="login_input">
                <input class="user_input" type="email" name="login_input_email" id="login_input_email" required>
                <br>
                <span class="error" id="error_email"></span> 
            </div>
    </div>

    <!-- Password -->
    <div class ="login_item">
            <div class= "user_field">
                <label for="login_password">
                    <span>Password</span>
                </label>
            </div>
            <div class="login_input">
                <input class="user_input" type="password" name="login_input_password" id="login_input_password" minlength="8" required>
                <br>
                <span class="error" id="error_password"></span> 
            </div>
    </div>

    <div class ="login_item">
            <div class= "user_field">
            </div>
            <div class="login_input right-aligned">
                <button type="submit" class="login_button" id="login_submit"> 
                    Login
                </button>
                <br>
                <span class="error" id="error_submit"></span> 
            </div>
        </div>
    </form>

    <div>
        <p>
            Don't have an account?
            Click <a href="user.php?action=signup">HERE</a> to create a new account.
        </p>
    </div>

</section>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database (replace these values with your database credentials)
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
    
} else {
    // Password is incorrect
    echo "Login failed. Please check your credentials.";
}

    $stmt->close();
    $conn->close();
}
?>


