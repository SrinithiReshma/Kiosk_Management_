<?php
// Establish database connection
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, "kiosk");

// Query to retrieve orders data with menu details and total bill for each order
$query = "SELECT o.order_id, o.Food_id, m.Food_Name, m.cost,o.totalBill
          FROM orders o
          INNER JOIN menu m ON o.Food_id = m.Food_id
          ORDER BY o.order_id";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KIOSK MENU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        .top-bar {
            background-color: #457B9D; /* Dark grey background */
            color: #ffffff; /* White text color */
            padding: 10px;
            display: flex;
            justify-content: space-between; /* Align items to the left and right edges */
            align-items: center; /* Center items vertically */
            text-align: center; /* Center text horizontally */
        }
        .btn-custom {
            background-color: #FFFFFF; /* Green */
            border: none;
            color: white;
            padding: 10px 24px;
            cursor: pointer;
            border-radius: 5px;
            margin-right: 10px;
        }
        .btn-custom:hover {
            background-color: #45a049;
        }
        .kiosk-heading {
            margin-left: 20px; /* Adjust left margin as needed */
        }
        .container {
            margin-top: 20px; /* Add space between top bar and container */
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <h2 class="kiosk-heading">MUG & BEAN</h2>
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <a class="nav-link" href="admin.php">Add Menu</a> <!-- Link to index.php -->
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php">View Products</a> <!-- Link to menu.php -->
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cart.php">Cart</a>
            </li>
        </ul>
    </div>
    <div class="container">
        <h1>Orders</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Food Name</th>
                    <th scope="col">Price</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php
                $currentOrderId = null; // Variable to track current order ID
                $totalBill = 0; // Variable to store total bill for each order

                // Check if there are any orders
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Check if it's a new order ID
                        if ($currentOrderId !== $row['order_id']) {
                            // If it's a new order ID, print the total bill for the previous order (if any)
                            if ($currentOrderId !== null) {
                                echo "<tr><td colspan='0.5'><strong>Total Cost:$totalBill</strong></td></tr>";
                                $totalBill = 0; // Reset total bill for the new order
                            }
                            $currentOrderId = $row['order_id']; // Update current order ID
                        }

                        // Display order details
                        echo "<tr>";
                        echo "<td>" . $row['order_id'] . "</td>";
                        echo "<td>" . $row['Food_Name'] . "</td>";
                        echo "<td>" . $row['cost'] . "</td>";
                        
                        echo "</tr>";

                        // Add the price to the total bill for the current order
                        $totalBill += $row['totalBill'];
                    }

                    // Print the total bill for the last order (if any)
                    echo "<tr><td colspan='0.5'><strong>Total Cost:$totalBill</strong></td></tr>";
                } else {
                    echo "<tr><td colspan='4'>No orders found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($connection);
?>
