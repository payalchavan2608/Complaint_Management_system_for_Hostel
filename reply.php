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

/* GET ID */
if(isset($_GET['id'])){
    $id = $_GET['id'];
}else{
    echo "Invalid Access";
    exit();
}

$admin_id = $_SESSION['admin_id'];

/* SEND REPLY */
if(isset($_POST['send'])){
    $reply = $_POST['reply'];

    mysqli_query($conn,"
    UPDATE complaints 
    SET reply='$reply', admin_id='$admin_id'
    WHERE id='$id'
    ");

    echo "<script>alert('Reply Sent');window.location='admin_dashboard.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Reply</title>

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

/* 🔥 BLUR BACKGROUND */
body::before{
    content:"";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;

    background:
    linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)),
    url('https://images.unsplash.com/photo-1522708323590-d24dbb6b0267') no-repeat center/cover;

    filter:blur(8px);
    transform:scale(1.1);
    z-index:-1;
}

/* BOX */
.box{
    background:rgba(255,255,255,0.95);
    padding:25px;
    border-radius:12px;
    width:320px;
    text-align:center;
    box-shadow:0 0 15px rgba(0,0,0,0.3);
}

h2{
    margin-bottom:15px;
}

/* TEXTAREA */
textarea{
    width:100%;
    height:100px;
    padding:10px;
    border-radius:8px;
    border:1px solid #ccc;
    resize:none;
    outline:none;
}

textarea:focus{
    border-color:#3498db;
    box-shadow:0 0 5px rgba(52,152,219,0.5);
}

/* BUTTON */
button{
    width:100%;
    padding:10px;
    margin-top:10px;
    background:#3498db;
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
}

button:hover{
    background:#2980b9;
}
</style>
</head>

<body>

<div class="box">
<h2>Send Reply</h2>

<form method="POST">
<textarea name="reply" placeholder="Write reply..." required></textarea>
<button name="send">Send Reply</button>
</form>

</div>

</body>
</html>