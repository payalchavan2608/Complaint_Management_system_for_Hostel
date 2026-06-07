<?php
session_start();

/* ✅ DATABASE CONNECTION (FIX FOR $conn ERROR) */
$conn = mysqli_connect("localhost","root","","complaint_db");

if(!$conn){
    die("Database Connection Failed: " . mysqli_connect_error());
}

/* ✅ CHECK LOGIN */
if(!isset($_SESSION['admin_id']) || !isset($_SESSION['role'])){
    header("Location: admin_login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$role     = $_SESSION['role'];

/* ✅ FILTER VALUES */
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
$to_date   = isset($_GET['to_date']) ? $_GET['to_date'] : '';
$status    = isset($_GET['status']) ? $_GET['status'] : '';

/* ✅ BASE QUERY (ADMIN-WISE) */
$query = "
SELECT complaints.*, 
       users.name AS student_name,
       users.room_no,
       users.block,
       categories.name AS category_name
FROM complaints
JOIN users ON complaints.user_id = users.id
JOIN categories ON complaints.category_id = categories.id
WHERE complaints.admin_id = '$admin_id'
";

/* ✅ APPLY FILTERS */
if(!empty($from_date) && !empty($to_date)){
    $query .= " AND DATE(complaints.created_at) 
                BETWEEN '$from_date' AND '$to_date'";
}

if(!empty($status)){
    $query .= " AND complaints.status = '$status'";
}

$query .= " ORDER BY complaints.id DESC";

/* ✅ RUN QUERY */
$q = mysqli_query($conn, $query);

if(!$q){
    die("Query Error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Complaint Report</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#f4f6f7;
    padding:20px;
}

/* HEADER */
.header{
    text-align:center;
    margin-bottom:20px;
}

/* FILTER BOX */
.filter-box{
    background:white;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
    display:flex;
    gap:10px;
    flex-wrap:wrap;
    justify-content:center;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

input, select, button{
    padding:10px;
    border-radius:6px;
    border:1px solid #ccc;
}

/* BUTTONS */
.btn{
    background:#3498db;
    color:white;
    border:none;
    cursor:pointer;
}

.reset{
    background:#e74c3c;
    color:white;
}

/* REPORT CARD STYLE (NOT GRID) */
.report{
    max-width:900px;
    margin:auto;
}

.card{
    background:white;
    padding:15px;
    border-radius:10px;
    margin-bottom:15px;
    box-shadow:0 2px 8px rgba(0,0,0,0.1);
}

/* STATUS COLORS */
.pending{color:red;font-weight:bold;}
.processing{color:orange;font-weight:bold;}
.resolved{color:green;font-weight:bold;}

.title{
    font-weight:bold;
    margin-bottom:5px;
}
</style>

</head>

<body>

<div class="header">
<h2><?php echo $role; ?> Complaint Report</h2>
</div>

<!-- ✅ FILTER FORM -->
<form method="GET">
<div class="filter-box">

<input type="date" name="from_date" value="<?php echo $from_date; ?>">
<input type="date" name="to_date" value="<?php echo $to_date; ?>">

<select name="status">
<option value="">All Status</option>
<option value="Pending" <?php if($status=="Pending") echo "selected"; ?>>Pending</option>
<option value="Processing" <?php if($status=="Processing") echo "selected"; ?>>Processing</option>
<option value="Resolved" <?php if($status=="Resolved") echo "selected"; ?>>Resolved</option>
</select>

<button type="submit" class="btn">Filter</button>

<a href="report.php">
<button type="button" class="reset">Reset</button>
</a>

</div>
</form>

<!-- ✅ REPORT VIEW (CARD STYLE) -->
<div class="report">

<?php
if(mysqli_num_rows($q) > 0){
    while($row = mysqli_fetch_assoc($q)){
?>

<div class="card">

<div class="title">Complaint ID: <?php echo $row['id']; ?></div>

<p><b>Student:</b> <?php echo $row['student_name']; ?></p>
<p><b>Room:</b> <?php echo $row['room_no']; ?> | Block: <?php echo $row['block']; ?></p>
<p><b>Category:</b> <?php echo $row['category_name']; ?></p>
<p><b>Description:</b> <?php echo $row['description']; ?></p>

<p><b>Date:</b> 
<?php echo date("d-M-Y", strtotime($row['created_at'])); ?>
</p>

<p><b>Status:</b> 
<span class="<?php echo strtolower($row['status']); ?>">
<?php echo $row['status']; ?>
</span>
</p>

</div>

<?php
    }
}else{
    echo "<p style='text-align:center;'>No records found</p>";
}
?>

</div>

</body>
</html>