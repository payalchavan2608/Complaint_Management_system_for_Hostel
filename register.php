<?php
include("db.php");

if(isset($_POST['register'])){

    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $block    = mysqli_real_escape_string($conn, $_POST['block']);
    $room_no  = mysqli_real_escape_string($conn, $_POST['room_no']);

    /* 🔐 HASH PASSWORD */
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // ✅ CHECK IF EMAIL EXISTS
    $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('Email already registered! Please login.');</script>";
    } else {

        // ✅ INSERT DATA
        $q = mysqli_query($conn,"
        INSERT INTO users(name,email,password,room_no,block)
        VALUES('$name','$email','$password','$room_no','$block')
        ");

        if($q){
            echo "<script>alert('Registered Successfully');window.location='login.php';</script>";
        }else{
            echo "Error: ".mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Register</title>

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
}

/* 🔥 BLUR BACKGROUND */
body::before{
    content:"";
    position:absolute;
    width:100%;
    height:100%;

    background:url('images/hostel.jpg') no-repeat center/cover;

    filter:blur(6px);
    transform:scale(1.1);
    z-index:-1;
}

.box{
    background:rgba(255,255,255,0.95);
    padding:30px;
    border-radius:12px;
    width:320px;
    text-align:center;
    box-shadow:0 0 15px rgba(0,0,0,0.3);
}

input, select{
    width:100%;
    padding:12px;
    margin:10px 0;
    border-radius:8px;
    border:1px solid #ccc;
}

button{
    width:100%;
    padding:12px;
    background:#2ecc71;
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
}

button:hover{
    background:#27ae60;
}
</style>

<script>
function loadRooms(){
    var block = document.getElementById("block").value;
    var room = document.getElementById("room_no");

    room.innerHTML = "<option value=''>Select Room</option>";

    var rooms = [];

    if(block === "A"){
        rooms = ["101","102","103","104"];
    }
    else if(block === "B"){
        rooms = ["201","202","203","204"];
    }
    else if(block === "C"){
        rooms = ["301","302","303","304"];
    }

    for(var i=0; i<rooms.length; i++){
        var option = document.createElement("option");
        option.value = rooms[i];
        option.text  = rooms[i];
        room.appendChild(option);
    }
}
</script>

</head>

<body>

<div class="box">

<h2>🏨 Student Registration</h2>

<form method="POST">

<input type="text" name="name" placeholder="Full Name" required>

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<select name="block" id="block" onchange="loadRooms()" required>
    <option value="">Select Block</option>
    <option value="A">Block A</option>
    <option value="B">Block B</option>
    <option value="C">Block C</option>
</select>

<select name="room_no" id="room_no" required>
    <option value="">Select Room</option>
</select>

<button name="register">Register</button>

<a href="login.php">Already have account? Login</a>

</form>

</div>

</body>
</html>