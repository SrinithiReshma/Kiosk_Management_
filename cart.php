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
                <a class="nav-link" href="order.php">Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cart.php">Cart</a>
            </li>
        </ul>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h1>Cart</h1>
                    </div>
                    <!-- Rest of the code remains the same -->

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Food ID</th>
                                    <th scope="col">Food Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Total Cost</th>
                                    <th scope="col">Action</th> <!-- Added column for delete button -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $connection = mysqli_connect("localhost", "root", "");
                                $db = mysqli_select_db($connection, "kiosk");

                                $query = "SELECT * FROM cart";
                                $result = mysqli_query($connection, $query);
                                $totalBill = 0; // Variable to store total bill

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $Food_id = $row['Food_id'];
                                    $Food_Name = $row['Food_Name'];
                                    $Price = $row['price'];
                                    $quantity = $row['quantity'];
                                    $Image_upload = $row['Image_upload'];
                                    $total_cost = $row['total_cost'];
                                    $totalBill += $total_cost; // Add total cost to total bill
                                ?>

                                <tr id="row_<?php echo $Food_id ?>"> <!-- Added ID to the table row -->
                                    <td><?php echo $Food_id ?></td>
                                    <td><?php echo $Food_Name ?></td>
                                    <td><?php echo $Price ?></td>
                                    <td><input type="number" value="<?php echo $quantity ?>" oninput="this.value = Math.abs(this.value); updateTotal(this, <?php echo $Price ?>, '<?php echo $Food_id ?>'); updateTotalBill()" id="quantity_<?php echo $Food_id ?>"></td>
                                    <td><img src="<?php echo $Image_upload ?>" alt="Food Image" style="width: 100px;"></td>
                                    <td><span id="total_<?php echo $Food_id ?>"><?php echo $total_cost ?></span></td>
                                    <td><button class="btn btn-danger" onclick="deleteItem('<?php echo $Food_id ?>')">Delete</button></td> <!-- Delete button -->
                                </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="5"></td>
                                    <td><strong>Total Bill:</strong></td>
                                    <td id="totalBill"><?php echo $totalBill; ?></td> <!-- Display total bill -->
                                </tr>
                                <tr>
                                    <td colspan="7"><button class="btn btn-primary" onclick="placeOrder()">Place Order</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateTotal(input, price, foodId) {
            var quantity = Math.abs(input.value);
            input.value = quantity; // Ensure positive integer is displayed
            var total = price * quantity;
            document.getElementById("total_" + foodId).innerText = total;
            // Send AJAX request to update database
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_cart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText); // Log response from server
                }
            };
            var params = "foodId=" + foodId + "&quantity=" + quantity + "&total=" + total;
            xhr.send(params);
        }

        function updateTotalBill() {
            var totalBill = 0;
            var totalCells = document.querySelectorAll('[id^="total_"]');
            totalCells.forEach(function(cell) {
                totalBill += parseInt(cell.innerText);
            });
            document.getElementById("totalBill").innerText = totalBill;
        }

        function deleteItem(foodId) {
            // Send AJAX request to delete item from database
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_item.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText); // Log response from server
                    // Remove row from table if deletion was successful
                    if (xhr.responseText.trim() === "success") {
                        var row = document.getElementById("row_" + foodId);
                        row.parentNode.removeChild(row);
                        updateTotalBill(); // Update total bill after deletion
                    }
                }
            };
            var params = "foodId=" + foodId;
            xhr.send(params);
        }

        function placeOrder() {
    // Get the cart items and total bill
    var cartItems = [];
    var totalCells = document.querySelectorAll('[id^="total_"]');
    var totalBill = document.getElementById("totalBill").innerText;

    // Iterate through the cart items and add them to the cartItems array
    totalCells.forEach(function(cell) {
        var foodId = cell.id.split("_")[1];
        var quantity = document.getElementById("quantity_" + foodId).value;
        var total = cell.innerText;
        cartItems.push({
            food_id: foodId,
            quantity: quantity,
            total_cost: total
        });
    });

    // Generate a random order ID
    var orderId = generateUniqueId();

    // Send the order data to the server using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "place_order.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText); // Log the server's response
            // Remove the rows from the cart table after successful order placement
            cartItems.forEach(function(item) {
                var row = document.getElementById("row_" + item.food_id);
                row.parentNode.removeChild(row);
            });
            // Reset total bill to zero
            document.getElementById("totalBill").innerText = "0";
            alert("Order placed successfully!");

            // After placing order, remove all rows from the cart table in the database
            var deleteCartItems = new XMLHttpRequest();
            deleteCartItems.open("POST", "delete_cart_items.php", true);
            deleteCartItems.setRequestHeader("Content-Type", "application/json");
            deleteCartItems.onreadystatechange = function() {
                if (deleteCartItems.readyState === 4 && deleteCartItems.status === 200) {
                    console.log(deleteCartItems.responseText); // Log the server's response
                }
            };
            deleteCartItems.send();
        }
    };
    var data = {
        order_id: orderId,
        items: cartItems,
        total_bill: totalBill
    };
    xhr.send(JSON.stringify(data));
}




        function generateUniqueId() {
            return 'order_' + Math.random().toString(36).substring(2, 10) + Math.random().toString(36).substring(2, 10);
        }
    </script>
</body>
</html>
