<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "haochi";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM products_menu"; // This query fetches all products from the table
$result = mysqli_query($conn, $sql);

$products = [];
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $products[] = $row; 
    }
} else {
    echo "0 results";
}

mysqli_close($conn);
?>
