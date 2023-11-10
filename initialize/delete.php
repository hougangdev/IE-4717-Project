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

// Disable foreign key checks
if (!mysqli_query($conn, 'SET FOREIGN_KEY_CHECKS=0')) {
    die("Error disabling foreign key checks: " . mysqli_error($conn));
}

// Retrieve all tables from the specified database
$sql = "SHOW TABLES FROM $database";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching table list: " . mysqli_error($conn));
}

// Initialize an array to store table names
$tables = array();

// Fetch each table name and add it to the tables array
while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
}

// Check if there are any tables to drop
if (empty($tables)) {
    echo "There are no tables in database $database.";
} else {
    // Start a loop to go through each table name and drop the table
    foreach ($tables as $table) {
        $dropQuery = "DROP TABLE $database.$table";
        if (mysqli_query($conn, $dropQuery)) {
            echo "Table $table dropped successfully<br>";
        } else {
            echo "Error dropping $table: " . mysqli_error($conn) . "<br>";
        }
    }
}

// Re-enable foreign key checks
if (!mysqli_query($conn, 'SET FOREIGN_KEY_CHECKS=1')) {
    die("Error enabling foreign key checks: " . mysqli_error($conn));
}

// Close connection
mysqli_close($conn);
?>
