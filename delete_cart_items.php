<?php
// Establish database connection
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, "kiosk");

// Query to delete all rows from the cart table
$query = "DELETE FROM cart";
$result = mysqli_query($connection, $query);

// Check if the deletion was successful
if ($result) {
    echo "All rows deleted from the cart table.";
} else {
    echo "Error: " . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
?>
