<?php
$conn=mysqli_connect("localhost","root","","project");
if(!$conn){
    die("connection failed".mysqli_error($conn));
}
?>