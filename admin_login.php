<?php
session_start();
include("../db.php");

/* CHECK DB CONNECTION */
if(!isset($conn)){
    die("Database not connected");
}

/* LOGIN LOGIC */
if(isset($_POST['login'])){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role     = trim($_POST['role']);

    /* VALIDATION */
    if(empty($role)){
        echo "<script>alert('Please select role');</script>";
    }else{

        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);
        $role     = mysqli_real_escape_string($conn, $role);

        $q = mysqli_query($conn,"
        SELECT * FROM admin 
        WHERE username='$username' 
        AND password='$password' 
        AND role='$role'
        ");

        /* QUERY ERROR CHECK */
        if(!$q){
            die("Query Error: " . mysqli_error($conn));
        }

        if(mysqli_num_rows($q) == 1){

            $row = mysqli_fetch_assoc($q);

            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['role']     = $row['role'];
            $_SESSION['username'] = $row['username'];

            header("Location: admin_dashboard.php");
            exit();

        }else{
            echo "<script>alert('Invalid Username, Password or Role');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>

<style>
body{
    margin:0;
    font-family:Arial;

    background:url('images/hostel.jpg') no-repeat center/cover;
    height:100vh;

    display:flex;
    justify-content:center;
    align-items:center;
}

.box{
    background:rgba(255,255,255,0.95);
    padding:30px;
    border-radius:12px;
    width:320px;
    text-align:center;
    box-shadow:0 4px 15px rgba(0,0,0,0.3);
}

h2{
    margin-bottom:15px;
}

/* 🔥 MAIN FIX (SAME AS PREVIOUS FORM) */
input, select, button{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:14px;
    box-sizing:border-box;  /* IMPORTANT */
}

/* INPUT STYLE */
input, select{
    background:#f9f9f9;
}

/* BUTTON */
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

/* FOCUS EFFECT */
input:focus, select:focus{
    border-color:#3498db;
    box-shadow:0 0 5px rgba(52,152,219,0.5);
    outline:none;
}
</style>
<script>
function validate(){
    var role = document.getElementById("role").value;

    if(role === ""){
        alert("Please select role first!");
        return false;
    }
    return true;
}
</script>

</head>

<body>

<div class="box">

<h2>🏨 Admin Login</h2>

<form method="POST" onsubmit="return validate()">

<select name="role" id="role" required>
    <option value="">Select Role</option>
    <option value="Warden">Warden</option>
    <option value="Security">Security</option>
    <option value="Canteen">Canteen</option>
</select>

<input type="text" name="username" placeholder="Enter Username" required>
<input type="password" name="password" placeholder="Enter Password" required>

<button type="submit" name="login">Login</button>

</form>

</div>

</body>
</html>