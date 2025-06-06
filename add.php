<?php
    $connection = mysqli_connect("localhost", "root", "");
    $db = mysqli_select_db($connection, "kiosk");

    if(isset($_POST['submit'])) {
        // Handle file upload
        $target_dir = "uploads/"; // Directory where you want to store uploaded files
        $target_file = $target_dir . basename($_FILES["Image_upload"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is a PNG image
        if($imageFileType != "png") {
            echo "Sorry, only PNG files are allowed.";
            exit;
        }

        // Move uploaded file to the target directory
        if (move_uploaded_file($_FILES["Image_upload"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["Image_upload"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }

        $Food_id = $_POST['Food_id'];
        $Food_Name = $_POST['Food_Name'];
        $cost = $_POST['cost'];
        $Description = $_POST['Description'];
        $Image_upload = $target_file; // Use $target_file as $Image_upload in your SQL query

        $sql = "INSERT INTO menu (Food_id, Food_Name, cost, Description, Image_upload) VALUES ('$Food_id', '$Food_Name', '$cost', '$Description', '$Image_upload')";

        if(mysqli_query($connection, $sql)) {
            echo '<script> location.replace("index.php")</script>';
        } else {
            echo "Something went wrong: " . mysqli_error($connection);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KIOSK MANAGEMENT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>

        <div class="container">
            <div class="row">
                 <div class="col-md-9">
                    <div class="card">
                    <div class="card-header">
                        <h1> KIOSK MANAGEMENT </h1>
                    </div>
                    <div class="card-body">

                    <form action="add.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                            <label>Food_id</label>
                            <input type="text" name="Food_id" class="form-control"  placeholder="Food Id:"> 
                        </div>
                        <div class="form-group">
                            <label>Food_Name</label>
                            <input type="text" name="Food_Name" class="form-control"  placeholder="Food Name"> 
                        </div>

                        <div class="form-group">
                            <label>cost</label>
                            <input type="text" name="cost" class="form-control"  placeholder="Enter cost"> 
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input type="text" name ="Description" class="form-control"  placeholder="enter description:"> 
                        </div>
                        <div class="form-group">
                            <label>Image_upload</label>
                            <input type="file" name="Image_upload" class="form-control" accept="image/png" required> 
                        </div>
                        
                        <br/>
                        <input type="submit" class="btn btn-primary" name="submit" value="Register">
                        </form>
                   
                    </div>
                    </div>

                </div>
            
            </div>
        </div>

</body>
</html>
