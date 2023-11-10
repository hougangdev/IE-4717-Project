<?php
// fetch_items_with_totals.php

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "haochi";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch product details, quantity sold, sorted by products_id
$sql = "SELECT p.products_id, p.products_name, 
               IFNULL(SUM(o.quantity), 0) as quantity_sold,
               IFNULL(SUM(o.quantity * o.price), 0) as total_earned
        FROM products_menu p
        LEFT JOIN haochi_orders o ON p.products_id = o.products_id
        GROUP BY p.products_id
        ORDER BY p.products_id ASC";
$result = $conn->query($sql);

// Initialize totals
$totalQuantitySold = 0;
$totalMoneyEarned = 0;

// Start table
echo "<table border='1'>";
echo "<tr><th>Product ID</th><th>Product Name</th><th>Quantity Sold</th><th>Total Earned</th></tr>";

if ($result->num_rows > 0) {
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    echo "<tr><td>" . $row["products_id"] . "</td><td>" . $row["products_name"] . "</td><td>" . $row["quantity_sold"] . "</td><td>$" . number_format($row["total_earned"], 2) . "</td></tr>";
    $totalQuantitySold += $row["quantity_sold"];
    $totalMoneyEarned += $row["total_earned"];
  }
} else {
  echo "<tr><td colspan='4'>No products found</td></tr>";
}

// Output totals
echo "<tr><th colspan='3'>Total Quantity Sold</th><td>$totalQuantitySold</td></tr>";
echo "<tr><th colspan='3'>Total Money Earned</th><td>$" . number_format($totalMoneyEarned, 2) . "</td></tr>";

// End table
echo "</table>";

$conn->close();
?>
