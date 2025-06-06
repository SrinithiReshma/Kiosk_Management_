<?php

$connection = mysqli_connect("localhost","root","");

$db = mysqli_select_db($connection,"kiosk");
$delete = $_GET['del'];


$sql = "delete from menu where Food_id = '$delete'";


if(mysqli_query($connection,$sql))
           {

            echo '<script> location.replace("index.php")</script>';  
           }
           else
           {
           echo "Some thing Error" . $connection->error;

           }

?>