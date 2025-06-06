<?php
// Establish database connection
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, "kiosk");

// Check if foodId is set and not empty
if(isset($_POST['foodId']) && !empty($_POST['foodId'])) {
    $foodId = $_POST['foodId'];

    // Delete item from cart table
    $query = "DELETE FROM cart WHERE Food_id = '$foodId'";
    $delete = mysqli_query($connection, $query);

    if($delete) {
        echo "success"; // Return success message if deletion is successful
    } else {
        echo "error"; // Return error message if deletion fails
    }
} else {
    echo "error"; // Return error message if foodId is not set or empty
}
?>
