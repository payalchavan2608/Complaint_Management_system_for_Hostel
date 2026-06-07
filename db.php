<?php
$conn = mysqli_connect("localhost", "root", "", "complaint_db");

/* CHECK CONNECTION */
if(!$conn){
    die("Database Connection Failed: " . mysqli_connect_error());
}
?>