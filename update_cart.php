<?php
// Establish database connection
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, "kiosk");

if(isset($_POST['foodId']) && isset($_POST['quantity']) && isset($_POST['total'])) {
    $foodId = $_POST['foodId'];
    $quantity = $_POST['quantity'];
    $total = $_POST['total'];

    // Update cart table with new quantity and total cost
    $query = "UPDATE cart SET quantity = '$quantity', total_cost = '$total' WHERE Food_id = '$foodId'";
    $update = mysqli_query($connection, $query);

    if($update) {
        echo "Cart updated successfully";
    } else {
        echo "Failed to update cart";
    }
}
?>
