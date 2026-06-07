<!DOCTYPE html>
<html>
<head>
<title>Hostel Complaint System</title>

<!-- ICON LIBRARY -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial;
}

body{
    background:linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
    url('https://images.unsplash.com/photo-1560448204-e02f11c3d0e2') no-repeat center/cover;
    color:white;
}

/* NAVBAR */
.navbar{
    display:flex;
    justify-content:space-between;
    padding:20px 40px;
}

.logo{
    font-size:22px;
    font-weight:bold;
}

.nav-links a{
    color:white;
    margin-left:20px;
    text-decoration:none;
}

/* HERO SECTION */
.hero{
    text-align:center;
    padding:80px 20px;
}

.hero h1{
    font-size:42px;
}

.hero p{
    max-width:600px;
    margin:15px auto;
}

/* BUTTONS */
.btn{
    padding:12px 20px;
    border:none;
    border-radius:8px;
    margin:10px;
    cursor:pointer;
    font-size:15px;
}

.student{background:#3498db;color:white;}
.admin{background:#e67e22;color:white;}
.register{background:#2ecc71;color:white;}

.btn:hover{
    transform:scale(1.05);
}

/* FEATURES */
.features{
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(10px);
    padding:40px;
    margin:20px;
    border-radius:15px;
}

.features h2{
    text-align:center;
    margin-bottom:20px;
}

.cards{
    display:flex;
    flex-wrap:wrap;
    justify-content:center;
    gap:20px;
}

.card{
    background:rgba(255,255,255,0.15);
    padding:20px;
    border-radius:12px;
    width:250px;
    text-align:center;
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
}

.card i{
    font-size:30px;
    margin-bottom:10px;
    color:#f1c40f;
}

/* FOOTER */
.footer{
    text-align:center;
    padding:15px;
    margin-top:20px;
}
</style>

</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
<div class="logo">🏨 Hostel System</div>

<div class="nav-links">
<a href="index.php">Home</a>
<a href="login.php">Student</a>
<a href="admin/admin_login.php">Admin</a>
</div>
</div>

<!-- HERO -->
<div class="hero">

<h1>Hostel Complaint Management System</h1>

<p>
A smart system to manage student complaints efficiently with tracking, reporting, and role-based access.
</p>

<a href="register.php"><button class="btn register">Register</button></a>
<a href="login.php"><button class="btn student">Student Login</button></a>
<a href="admin/admin_login.php"><button class="btn admin">Admin Login</button></a>

</div>

<!-- FEATURES -->
<div class="features">

<h2>✨ Key Features</h2>

<div class="cards">

<div class="card">
<i class="fas fa-edit"></i>
<h3>Easy Complaint</h3>
<p>Submit complaints with description and images easily.</p>
</div>

<div class="card">
<i class="fas fa-chart-line"></i>
<h3>Track Status</h3>
<p>Monitor complaint progress in real-time.</p>
</div>

<div class="card">
<i class="fas fa-user-shield"></i>
<h3>Admin Panel</h3>
<p>Admins manage, update and resolve complaints.</p>
</div>

<div class="card">
<i class="fas fa-file-alt"></i>
<h3>Reports</h3>
<p>Generate reports with filters and export options.</p>
</div>

</div>

</div>

<!-- FOOTER -->
<div class="footer">
<p>© 2026 Hostel Complaint System</p>
</div>

</body>
</html>