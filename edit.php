<?php
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, "kiosk");

if(isset($_GET['edit'])) {
    $edit = $_GET['edit'];
    
    // Fetch the record to be edited
    $sql = "SELECT * FROM menu WHERE Food_id = '$edit'";
    $run = mysqli_query($connection, $sql);

    // Check if record exists
    if(mysqli_num_rows($run) > 0) {
        $row = mysqli_fetch_assoc($run);
        $Food_id = $row['Food_id'];
        $Food_Name = $row['Food_Name'];
        $cost = $row['cost'];
        $Description = $row['Description'];
        $Image_upload = $row['Image_upload'];
    } else {
        echo "Record not found.";
        exit();
    }
}

if(isset($_POST['submit'])) {
    $edit = $_GET['edit'];  
    $Food_id = $_POST['Food_id'];
    $Food_Name = $_POST['Food_Name'];
    $cost = $_POST['cost'];
    $Description = $_POST['Description'];

    // Check if new image uploaded
    if(isset($_FILES["image_upload"]) && $_FILES["image_upload"]["error"] == 0) {
        // Handle file upload
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image_upload"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if file is a PNG image
        if($imageFileType != "png") {
            echo "Sorry, only PNG files are allowed.";
            exit;
        }

        // Move uploaded file to the target directory
        if (move_uploaded_file($_FILES["image_upload"]["tmp_name"], $target_file)) {
            $Image_upload = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit;
        }
    }

    // Update the record in the database
    $sql = "UPDATE menu SET Food_id = '$Food_id', Food_Name = '$Food_Name', cost = '$cost', Description = '$Description', Image_upload = '$Image_upload' WHERE Food_id = '$edit'";
    if(mysqli_query($connection, $sql)) {
        echo '<script>location.replace("index.php")</script>';
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
    <title>KIOSK MANAGEMENT Application</title>
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
                        <form action="edit.php?edit=<?php echo $edit; ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Food_id</label>
                                <input type="text" name="Food_id" class="form-control" placeholder="Food Id:" value="<?php echo $Food_id; ?>"> 
                            </div>
                            <div class="form-group">
                                <label>Food_Name</label>
                                <input type="text" name="Food_Name" class="form-control" placeholder="Food Name" value="<?php echo $Food_Name; ?>"> 
                            </div>
                            <div class="form-group">
                                <label>cost</label>
                                <input type="text" name="cost" class="form-control" placeholder="Enter cost" value="<?php echo $cost; ?>"> 
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" name="Description" class="form-control" placeholder="Enter description:" value="<?php echo $Description; ?>"> 
                            </div>
                            <div class="form-group">
                                <label>Image_upload</label>
                                <input type="file" name="image_upload" class="form-control">
                            </div>
                            <br/>
                            <input type="submit" class="btn btn-primary" name="submit" value="Edit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
