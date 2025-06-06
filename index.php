<?php
// Establish database connection
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, "kiosk");

if(isset($_POST['addToCart'])) {
    // Retrieve form data
    $Food_id = $_POST['Food_id'];
    $Food_Name = $_POST['Food_Name'];
    $Price = $_POST['cost'];
    $Image_upload = $_POST['Image_upload'];
    $quantity = 1; // Default quantity
    
    // Insert into cart table
    $query = "INSERT INTO cart (Food_id, Food_Name, price, quantity, Image_upload,total_cost) VALUES ('$Food_id', '$Food_Name', '$Price', '$quantity', '$Image_upload','$Price')";
    $insert = mysqli_query($connection, $query);
    
    if($insert) {
        echo "<script>alert('Item added to cart successfully');</script>";
    } else {
        echo "<script>alert('Failed to add item to cart');</script>";
    }
}
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
                <a class="nav-link" href="order.php">Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cart.php">Cart</a>
            </li>
        </ul>
    </div>
    <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            $sql = "SELECT * FROM menu";
            $run = mysqli_query($connection, $sql);

            while ($row = mysqli_fetch_array($run)) {
                $Food_id = $row['Food_id'];
                $Food_Name = $row['Food_Name'];
                $cost = $row['cost'];
                $Description = $row['Description'];
                $Image_upload = $row['Image_upload'];
            ?>

            <div class="col">
                <div class="card h-100">
                    <img src="<?php echo $Image_upload ?>" class="card-img-top" alt="Food Image" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $Food_Name ?></h5>
                        <p class="card-text"><?php echo $Description ?></p>
                        <p class="card-text">Cost: $<?php echo $cost ?></p>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary" onclick="addToCart('<?php echo $Food_id ?>', '<?php echo $Food_Name ?>', '<?php echo $cost ?>', '<?php echo $Image_upload ?>')">Add to Cart</button>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <script>
// JavaScript for handling AJAX request
function addToCart(Food_id, Food_Name, cost, Image_upload) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "", true); // URL to your PHP script (current page)
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                alert('Item added to cart successfully');
            } else {
                alert('Failed to add item to cart');
            }
        }
    };
    var params = "addToCart=true&Food_id=" + Food_id + "&Food_Name=" + Food_Name + "&cost=" + cost + "&Image_upload=" + Image_upload;
    xhr.send(params);
}
</script>

</body>
</html>
