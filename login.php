<?php
session_start();
include("db.php");

/* CHECK CONNECTION */
if(!$conn){
    die("Database connection failed: " . mysqli_connect_error());
}

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    /* GET USER */
    $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if($q && mysqli_num_rows($q) == 1){

        $row = mysqli_fetch_assoc($q);

        /* 🔐 VERIFY HASH PASSWORD */
        if(password_verify($password, $row['password'])){

            $_SESSION['user_id'] = $row['id'];

            header("Location: dashboard.php");
            exit();

        }else{
            echo "<script>alert('Incorrect Password');</script>";
        }

    }else{
        echo "<script>alert('User not found');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>User Login</title>

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
    z-index:1;
}

/* 🔥 BLURRED BACKGROUND */
body::before{
    content:"";
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;

    background:url('https://images.unsplash.com/photo-1505693416388-ac5ce068fe85') no-repeat center/cover;

    filter:blur(8px);        /* 🔥 control blur here */
    transform:scale(1.1);    /* prevents white edges */

    z-index:-2;
}

/* OPTIONAL DARK OVERLAY (for better readability) */
body::after{
    content:"";
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;

    background:rgba(0,0,0,0.3);

    z-index:-1;
}

.box{
    background:rgba(255,255,255,0.9);
    padding:30px;
    border-radius:15px;
    width:320px;
    text-align:center;
    box-shadow:0 0 15px rgba(0,0,0,0.3);
}

h2{
    margin-bottom:15px;
}

input, button{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:14px;
}

input{
    background:#f9f9f9;
}

button{
    background:#3498db;
    color:white;
    border:none;
    cursor:pointer;
    font-weight:bold;
}

button:hover{
    background:#2980b9;
}

a{
    display:block;
    margin-top:8px;
    font-size:14px;
    color:#333;
    text-decoration:none;
}

a:hover{
    text-decoration:underline;
}
</style>

</head>

<body>

<div class="box">

<h2>Login</h2>

<form method="POST">

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit" name="login">Login</button>

<a href="forgot_password.php">Forgot Password?</a>


</form>

</div>

</body>
</html>