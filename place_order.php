<?php
// Establish database connection
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, "kiosk");

// Get the highest order ID from the orders table
$query = "SELECT MAX(order_id) AS max_order_id FROM orders";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
$maxOrderId = $row['max_order_id'];

// Generate the new order ID
$newOrderId = ($maxOrderId !== null) ? $maxOrderId + 1 : 1;

// Get the items and total bill from the AJAX request
$data = json_decode(file_get_contents("php://input"), true);
$items = $data['items'];
$totalBill = $data['total_bill'];

// Insert the order details into the database
foreach ($items as $item) {
    $foodId = $item['food_id'];
    $quantity = $item['quantity'];
    $totalCost = $item['total_cost'];
    $query = "INSERT INTO orders (order_id, Food_id, totalBill) VALUES ('$newOrderId', '$foodId', '$totalCost')";
    $result = mysqli_query($connection, $query);
}

// Check if the insertion was successful
if ($result) {
    echo "Order placed successfully!";
} else {
    echo "Error: " . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
?>
