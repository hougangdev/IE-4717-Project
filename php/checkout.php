<?php
session_start();
// File: checkout.php
include 'database_operations.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['user_id'])) {
        $customerId = $_SESSION['user_id']; // Retrieve from session
    } else {
        echo "You must be logged in to place an order.";
        exit; // Prevent further execution if the user is not logged in
    }

    $receiptId = 'RECEIPT' . uniqid(); // Unique receipt ID for the order

    // Retrieve product IDs and quantities from POST data
    $productIds = $_POST['product_id'];
    $quantities = $_POST['quantity'];

    // Initialize email content
    $emailContent = "Order Summary:\n";

    // Begin database transaction
    $conn->beginTransaction();

    // Loop through all products to process individual orders
    for ($i = 0; $i < count($productIds); $i++) {
        $productId = $productIds[$i];
        $quantity = intval($quantities[$i]);

        // Retrieve the current price from the database
        $stmt = $conn->prepare("SELECT products_price FROM products_menu WHERE products_id = ?");
        $stmt->execute([$productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product && $quantity > 0) {
            $price = floatval($product['products_price']); // Ensure the price is a float value
            try {
                // Insert the order into the database
                $stmt = $conn->prepare("INSERT INTO haochi_orders (receipt_id, products_id, customer_id, price, quantity) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$receiptId, $productId, $customerId, $price, $quantity]);
            } catch(PDOException $e) {
                // Rollback transaction if any operation fails
                $conn->rollback();
                echo "Error: " . $e->getMessage();
                exit;
            }
        }
    }

    // Commit the transaction
    $conn->commit();

    // Fetch the order details only once after all orders have been inserted
    try {
        $fetchOrderItemsStmt = $conn->prepare("SELECT p.products_name, o.price, o.quantity FROM haochi_orders o
                                                JOIN products_menu p ON o.products_id = p.products_id
                                                WHERE o.receipt_id = ?");
        $fetchOrderItemsStmt->execute([$receiptId]);
        $orderItems = $fetchOrderItemsStmt->fetchAll(PDO::FETCH_ASSOC);

        // Build the email content
        foreach ($orderItems as $item) {
            $emailContent .= "Product Name: {$item['products_name']}, Quantity: {$item['quantity']}, Price per item: $" . number_format($item['price'], 2) . "\n";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }

    // Fetch the email address of the customer
    try {
        $stmt = $conn->prepare("SELECT email FROM customers WHERE customer_id = :customer_id");
        $stmt->bindParam(':customer_id', $customerId);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $userEmail = $user['email'];

            // Define the email parameters
            $subject = "Your Order Confirmation (Order ID: $receiptId)";
            $message = $emailContent; // Assuming $emailContent is already defined with the order details
            $headers = "From: haochi@localhost\r\n";
            $headers .= "Reply-To: haochi@localhost\r\n";
            $headers .= "X-Mailer: PHP/" . phpversion();
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n"; // To ensure proper encoding
        

            // Send the email
            $mailSent = mail($userEmail, $subject, $message, $headers, '-fhaochi@localhost');

            // Notify user of success
            echo "Order successfully placed and confirmation email sent!";

            // Clear 'cart' and then redirect to the success page
            echo '<script type="text/javascript">',
                'sessionStorage.removeItem("cart");', // Clear the 'cart' item
                'window.location.href = "greatsuccess.php";', // Redirect to the success page
                '</script>';
            exit;


        } else {
            echo "Error: Customer not found.";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
    // This line unsets the 'cart' session variable, effectively clearing the cart
   

    $conn = null; 

} else {
    // Redirect if not a POST request
    header('Location: form.html');
}
?>
