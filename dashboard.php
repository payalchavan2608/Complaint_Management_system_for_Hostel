<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("location:login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>User Dashboard</title>

<style>
body{
    margin:0;
    font-family:Arial;
    height:100vh;
    color:white;

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

    background:url('https://images.unsplash.com/photo-1505691938895-1758d7feb511') no-repeat center/cover;

    filter:blur(8px);        /* adjust blur */
    transform:scale(1.1);

    z-index:-2;
}

/* OPTIONAL DARK OVERLAY */
body::after{
    content:"";
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;

    background:rgba(0,0,0,0.4);

    z-index:-1;
}

/* HEADER */
.header{
    background:rgba(0,0,0,0.6);
    padding:15px;
    text-align:center;
    font-size:22px;
}

/* CONTAINER */
.container{
    display:flex;
    justify-content:center;
    align-items:center;
    height:80vh;
    gap:30px;
}

/* CARD STYLE */
.card{
    width:220px;
    height:160px;
    background:rgba(255,255,255,0.2);
    backdrop-filter:blur(10px);
    border-radius:15px;
    text-align:center;
    padding-top:40px;
    cursor:pointer;
    transition:0.3s;
    box-shadow:0 5px 15px rgba(0,0,0,0.3);
}

/* HOVER EFFECT */
.card:hover{
    transform:scale(1.05);
    background:rgba(255,255,255,0.3);
}
.card:hover{
    transform:scale(1.05);
    background:#3498db;
}

/* ICON */
.icon{
    font-size:40px;
    margin-bottom:10px;
}

/* TEXT */
.card h3{
    margin:0;
}

/* FOOTER */
.footer{
    position:absolute;
    bottom:10px;
    width:100%;
    text-align:center;
    font-size:14px;
}
</style>

</head>
<body>

<div class="header">
🏨 User Dashboard
</div>

<div class="container">

<div class="card" onclick="location.href='submit_complaint.php'">
<div class="icon">📝</div>
<h3>Submit Complaint</h3>
</div>

<div class="card" onclick="location.href='view_complaint.php'">
<div class="icon">📄</div>
<h3>View Complaints</h3>
</div>

<div class="card" onclick="location.href='logout.php'">
<div class="icon">🚪</div>
<h3>Logout</h3>
</div>

</div>

<div class="footer">
© Hostel Complaint System
</div>

</body>
</html>