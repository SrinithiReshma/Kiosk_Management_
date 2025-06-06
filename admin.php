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
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h1> KIOSK MANAGEMENT</h1>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-success"> <a href="add.php" class="text-light"> Add New </a> </button>
                        <br/>
                        <br/>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Food_id</th>
                                    <th scope="col">Food_Name</th>
                                    <th scope="col">cost</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $connection = mysqli_connect("localhost", "root", "");
                                $db = mysqli_select_db($connection, "kiosk");

                                $sql = "SELECT * FROM menu";
                                $run = mysqli_query($connection, $sql);

                                while ($row = mysqli_fetch_array($run)) {
                                    $Food_id = $row['Food_id'];
                                    $Food_Name = $row['Food_Name'];
                                    $cost = $row['cost'];
                                    $Description = $row['Description'];
                                    $Image_upload = $row['Image_upload'];
                                ?>

                                <tr>
                                    <td><?php echo $Food_id ?></td>
                                    <td><?php echo $Food_Name ?></td>
                                    <td><?php echo $cost ?></td>
                                    <td><?php echo $Description ?></td>
                                    <td><img src="<?php echo $Image_upload ?>" alt="Food Image" style="width: 100px;"></td>
                                    <td>
                                        <button class="btn btn-success"> <a href='edit.php?edit=<?php echo $Food_id ?>' class="text-light"> Edit </a> </button>
                                        <button class="btn btn-danger"><a href='delete.php?del=<?php echo $Food_id ?>' class="text-light"> Delete </a> </button>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
