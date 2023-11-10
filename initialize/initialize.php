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


// SQL to create customers table with password field
$sql = "CREATE TABLE IF NOT EXISTS customers (
    customer_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,  
	address TEXT, 
    postal INT(6)
) ENGINE=InnoDB"; 

if (mysqli_query($conn, $sql)) {
    echo "Table customers created successfully";
} else {
    echo "Error creating customers table: " . mysqli_error($conn);
}

// Check if the customers table is empty
$sql = "SELECT * FROM customers";
$result = mysqli_query($conn, $sql) or die ("<br>Error in query: $sql. ".mysqli_error($conn));

if (mysqli_num_rows($result) == 0) {
    echo "<br>Customers table is empty, adding a test user.";

    // Hash the password
    $hashed_password = password_hash('password112233', PASSWORD_DEFAULT);

    // Insert a test user into the customers table
    $sql = "INSERT INTO customers (username, email, password, address, postal) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    
    // Bind parameters
    $username = "customer";
    $email = "customer@localhost";
    $address = "Addy";
    $postal = 542321;
    
    mysqli_stmt_bind_param($stmt, "ssssi", $username, $email, $hashed_password, $address, $postal);
    
    // Execute statement
    if (mysqli_stmt_execute($stmt)) {
        echo "<br>Test user created successfully";
    } else {
        echo "<br>Error inserting test user: " . mysqli_error($conn);
    }

    // Close statement
    mysqli_stmt_close($stmt);
} else {
    echo "<br>Customers table is not empty.";
}


// sql to create product table
// should consist of all products
$sql = "CREATE TABLE IF NOT EXISTS products_menu (
    products_category VARCHAR(50) NOT NULL,
	products_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	products_name VARCHAR(30) NOT NULL,
	products_price DOUBLE NOT NULL
	)";
if (mysqli_query($conn, $sql)) {
	echo "Table products_menu created successfully";
} else {
	echo "Error creating products_menu Table: " . mysqli_error($conn);
}


// SQL to create haochi_orders table

$sql = "CREATE TABLE IF NOT EXISTS haochi_orders (
    order_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    receipt_id VARCHAR(50) NOT NULL,
    products_id INT(6) UNSIGNED NOT NULL, 
    customer_id INT(6) UNSIGNED NOT NULL,
    price DOUBLE NOT NULL,
    quantity INT UNSIGNED NOT NULL,
    FOREIGN KEY (products_id) REFERENCES products_menu(products_id),  
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
) ENGINE=InnoDB";  

if (mysqli_query($conn, $sql)) {
    echo "<br>Table haochi_orders created successfully";
} else {
    echo "<br>Error creating haochi_orders table: " . mysqli_error($conn);
}



// check if empty
$sql = "SELECT * FROM products_menu";
$result = mysqli_query($conn, $sql) or die ("<br>Error in query: $sql. ".mysql_error());

if (mysqli_num_rows($result) > 0) {
 echo "<br>Table is not Empty";
}
else {
	echo "<br>Table is Empty, adding new records";
	//sql to insert into product table

    // Seafood Menu
	$sql = "INSERT INTO products_menu (products_id, products_name, products_category, products_price)
	VALUES (NULL, 'Clam Pasta', 'SEAFOOD', 12.00);";
	$sql .= "INSERT INTO products_menu (products_id, products_name, products_category, products_price)
	VALUES (NULL, 'Seafood Royale', 'SEAFOOD', 19.00);";
	$sql .= "INSERT INTO products_menu (products_id, products_name, products_category, products_price)
	VALUES (NULL, 'Lobster Soup', 'SEAFOOD', 21.00);";

    // Meat Menu
	$sql .= "INSERT INTO products_menu (products_id, products_name, products_category, products_price)
	VALUES (NULL, 'Chicken Chop', 'MEAT', 12.99);";
	$sql .= "INSERT INTO products_menu (products_id, products_name, products_category, products_price)
	VALUES (NULL, 'Lamb Chop', 'MEAT', 13.99);";
    $sql .= "INSERT INTO products_menu (products_id, products_name, products_category, products_price)
	VALUES (NULL, 'A4 Wagyu Steak', 'MEAT', 30.99);";

    // Vegetarian Menu
    $sql .= "INSERT INTO products_menu (products_id, products_name, products_category, products_price)
	VALUES (NULL, 'Salad Bowl Set A', 'VEGE', 8.99);";
    $sql .= "INSERT INTO products_menu (products_id, products_name, products_category, products_price)
	VALUES (NULL, 'Salad Bowl Set B', 'VEGE', 10.99);";
    $sql .= "INSERT INTO products_menu (products_id, products_name, products_category, products_price)
	VALUES (NULL, 'Salad Bowl Set B', 'VEGE', 12.99);";

    // Halal Menu
    $sql .= "INSERT INTO products_menu (products_id, products_name, products_category, products_price)
	VALUES (NULL, 'Halal Product 1', 'HALAL', 10.70);";
    $sql .= "INSERT INTO products_menu (products_id, products_name, products_category, products_price)
	VALUES (NULL, 'Halal Product 2', 'HALAL', 9.50);";
    $sql .= "INSERT INTO products_menu (products_id, products_name, products_category, products_price)
	VALUES (NULL, 'Halal Product 3', 'HALAL', 9.75);";
    


	if (mysqli_multi_query($conn, $sql)) {
		echo "<br>New records created successfully";
	} else {
		echo "<br>Error inserting into product table: " . mysqli_error($conn);
	}
}


mysqli_close($conn);
?>
