<?php
include("db.php");

if(isset($_POST['check'])){
    $email = $_POST['email'];

    $q = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($q) == 1){
        header("location:reset_password.php?email=$email");
    }else{
        echo "<script>alert('Email not found');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Forgot Password</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:url('https://images.unsplash.com/photo-1522708323590-d24dbb6b0267') no-repeat center/cover;
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.box{
    background:rgba(255,255,255,0.9);
    padding:30px;
    border-radius:10px;
    text-align:center;
    width:300px;
}

input,button{
    width:100%;
    padding:10px;
    margin:10px 0;
    border-radius:8px;
}

button{
    background:#3498db;
    color:white;
    border:none;
}
</style>
</head>

<body>

<div class="box">
<h2>Forgot Password</h2>

<form method="POST">
<input type="email" name="email" placeholder="Enter Email" required>
<button name="check">Next</button>
</form>

</div>

</body>
</html>