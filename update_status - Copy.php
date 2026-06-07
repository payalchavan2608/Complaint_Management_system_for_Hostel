<?php
session_start();
include("../db.php");

/* CHECK DB CONNECTION */
if(!isset($conn)){
    die("Database not connected");
}

/* CHECK LOGIN */
if(!isset($_SESSION['admin_id'])){
    header("location:admin_login.php");
    exit();
}

/* CHECK ID */
if(!isset($_GET['id'])){
    die("No Complaint ID");
}

$id = $_GET['id'];
$admin_id = $_SESSION['admin_id'];

/* UPDATE STATUS */
if(isset($_POST['update'])){
    $status = $_POST['status'];

    $q = mysqli_query($conn,"
    UPDATE complaints 
    SET status='$status', admin_id='$admin_id'
    WHERE id='$id'
    ");

    if($q){
        echo "<script>alert('Status Updated Successfully');window.location='admin_dashboard.php';</script>";
    }else{
        echo "Error: ".mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Update Status</title>

<style>
*{
    box-sizing:border-box;
}

body{
    margin:0;
    font-family:Arial;
    height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;

    position:relative;
    overflow:hidden;
}

/* 🔥 BLURRED BACKGROUND */
body::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;

    background:
    linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)),
    url('https://images.unsplash.com/photo-1505691938895-1758d7feb511') no-repeat center/cover;

    filter:blur(8px);
    transform:scale(1.1);
    z-index:-1;
}

/* BOX */
.box{
    background:rgba(255,255,255,0.95);
    padding:30px;
    border-radius:12px;
    width:320px;
    text-align:center;
    box-shadow:0 0 15px rgba(0,0,0,0.3);
}

h2{
    margin-bottom:15px;
}

/* SELECT + BUTTON */
select, button{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:14px;
}

/* SELECT */
select{
    background:#f9f9f9;
}

/* BUTTON */
button{
    background:#27ae60;
    color:white;
    border:none;
    cursor:pointer;
    font-weight:bold;
}

button:hover{
    background:#219150;
}
</style>

<script>
function confirmUpdate(){
    return confirm("Are you sure you want to update status?");
}
</script>

</head>

<body>

<div class="box">

<h2>Update Complaint Status</h2>

<form method="POST" onsubmit="return confirmUpdate()">

<select name="status" required>
    <option value="">Select Status</option>
    <option>Pending</option>
    <option>Processing</option>
    <option>Resolved</option>
</select>

<button name="update">Update</button>

</form>

</div>

</body>
</html>