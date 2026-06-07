<?php
include("db.php");

if(!isset($_GET['email'])){
    echo "Invalid Access";
    exit();
}

$email = $_GET['email'];

if(isset($_POST['reset'])){
    $newpass = $_POST['password'];

    mysqli_query($conn,"UPDATE users SET password='$newpass' WHERE email='$email'");

    echo "<script>alert('Password Updated');window.location='login.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Reset Password</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:url('https://images.unsplash.com/photo-1505691938895-1758d7feb511') no-repeat center/cover;
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
    background:#2ecc71;
    color:white;
    border:none;
}
</style>

<script>
function validate(){
    var p1 = document.getElementById("p1").value;
    var p2 = document.getElementById("p2").value;

    if(p1 !== p2){
        alert("Passwords do not match!");
        return false;
    }
    return true;
}
</script>

</head>
<body>

<div class="box">
<h2>Reset Password</h2>

<form method="POST" onsubmit="return validate()">

<input type="password" id="p1" name="password" placeholder="New Password" required>
<input type="password" id="p2" placeholder="Confirm Password" required>

<button name="reset">Reset Password</button>

</form>

</div>

</body>
</html>