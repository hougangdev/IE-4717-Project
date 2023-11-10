
<section class = "register">
    <form action="<?= htmlentities($_SERVER['PHP_SELF']) ?>" method = "post" class="form_user" id="form_user" data-id="register">

        <h1 class = "user_title">Registration</h1>

        <input type="text" name="type" value="register" hidden required>
        <!-- Username -->
        <div class ="registration_item">
            <div class= "user_field">
                <label for="registration_name">
                    <span>Username</span>
                </label>
            </div>
            <div class="registration_input">
                <input class="user_input" type="text" name="registration_input_name" id="registration_input_name" required>
                <br>
                <span class="error" id="error_name"></span> 
            </div>
        </div>
        
        <!--Email-->
        <div class ="registration_item">
            <div class= "user_field">
                <label for="registration_email">
                    <span>E-mail</span>
                </label>
            </div>
            <div class="registration_input">
                <input class="user_input" type="email" name="registration_input_email" id="registration_input_email" required>
                <br>
                <span class="error" id="error_email"></span> 
            </div>
        </div>

        <!-- Password -->
        <div class ="registration_item">
            <div class= "user_field">
                <label for="registration_password">
                    <span>Password</span>
                </label>
            </div>
            <div class="registration_input">
                <input class="user_input" type="password" name="registration_input_password" id="registration_input_password" minlength="8" required>
                <br>
                <span class="error" id="error_password"></span> 
            </div>
        </div>

        <!-- Address -->
        <div class ="registration_item">
            <div class= "user_field">
                
                    <span>Address</span>
                
            </div>
            <div class="registration_input">
                <input class="user_input" type="text" name="registration_input_address" id="registration_input_address" required>
                <br>
                <span class="error" id="error_password"></span> 
            </div>
        </div>

        <!-- Postal -->
        <div class ="registration_item">
            <div class= "user_field">
                
                    <span>Postal</span>
                
            </div>
            <div class="registration_input">
                <input class="user_input" name="registration_input_postal" id="registration_input_postal" required>
                <br>
                <span class="error" id="error_postal"></span> 
            </div>
        </div>

        <div class ="registration_item">
            <div class= "user_field">
            </div>
            <div class="registration_input right-aligned">
                <button type="submit" class="registration_button" id="registration_submit"> 
                    Register
                </button>
                <br>
                <span class="error" id="error_submit"></span> 
            </div>
        </div>
    </form>

    <div>
        <p>
            Already have an account? 
            Click <a href="user.php">HERE</a> to login.
        </p>
    </div>
</section>

<?php
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

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert user data into the database
    $sql = "INSERT INTO customers (username, password, email, address, postal) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $hashed_password, $email, $address, $postal);

    if ($stmt->execute()) {
        // Registration successful
        echo "Registration successful!";
    } else {
        // Registration failed
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>