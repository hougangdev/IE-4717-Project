
<?php

function getProductInfo($product_id) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "haochi";

    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Build the SQL query
    $sql = "SELECT product_name FROM products WHERE product_id = ?";

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);

    // Execute the query
    $stmt->execute();

    // Bind the result
    $stmt->bind_result($product_name);

    // Check if there is a result
    if ($stmt->fetch()) {
        return $product_name;
    } else {
        return "Product not found"; 
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}

// Initialize the cart as an empty array if it doesn't exist in the cookie
$cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];

// Handle adding a product to the cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = intval($_POST['quantity']);

    // Check if the product is already in the cart
    if (array_key_exists($product_id, $cart)) {
        // Increment the quantity if the product is already in the cart
        $cart[$product_id] += $quantity;
    } else {
        // Add the product to the cart if it's not already there
        $cart[$product_id] = $quantity;
    }

    // Store the updated cart in a cookie
    setcookie('cart', json_encode($cart), time() + 3600, '/'); // 1 hour expiration
}

// Display the cart
echo '<h2>Shopping Cart</h2>';
echo '<ul>';
foreach ($cart as $product_id => $quantity) {
    // Retrieve product information from your database based on $product_id
    $product_name = getProductInfo($product_id); 

    echo '<li>' . $product_name . ' (Quantity: ' . $quantity . ')</li>';
}
echo '</ul>';

?>


