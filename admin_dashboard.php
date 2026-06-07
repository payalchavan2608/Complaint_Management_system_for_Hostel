<?php
session_start();
include("../db.php");

/* CHECK DB CONNECTION */
if(!isset($conn)){
    die("Database not connected");
}

/* ✅ CHECK LOGIN */
if(!isset($_SESSION['admin_id'])){
    header("location:admin_login.php");
    exit();
}

/* ✅ SESSION VALUES */
$admin_id = $_SESSION['admin_id'];
$role = isset($_SESSION['role']) ? $_SESSION['role'] : "Admin";

/* ✅ FETCH ONLY THIS ADMIN'S COMPLAINTS */
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
ORDER BY complaints.id DESC
";

$q = mysqli_query($conn, $query);

if(!$q){
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>

<style>
body{
    margin:0;
    font-family:Arial;
    background:#ecf0f1;
    padding:20px;
}

h2{
    text-align:center;
}

/* TABLE */
table{
    width:100%;
    border-collapse:collapse;
    background:white;
}

th,td{
    padding:10px;
    border:1px solid #ccc;
    text-align:center;
}

th{
    background:#34495e;
    color:white;
}

/* STATUS */
.pending{color:red;font-weight:bold;}
.processing{color:orange;font-weight:bold;}
.resolved{color:green;font-weight:bold;}

/* IMAGE */
img{
    width:70px;
    border-radius:6px;
    cursor:pointer;
    transition:0.3s;
}
img:hover{
    transform:scale(1.1);
}

/* BUTTONS */
button{
    padding:8px 14px;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-weight:bold;
}

/* ACTION BUTTONS */
.update{background:#3498db;color:white;}
.reply{background:#2ecc71;color:white;}

.update:hover{background:#2980b9;}
.reply:hover{background:#27ae60;}

/* BOTTOM BUTTONS */
.bottom-buttons{
    margin-top:20px;
    text-align:center;
}

.report{
    background:#8e44ad;
    color:white;
    margin-right:10px;
}
.report:hover{
    background:#732d91;
}

.logout{
    background:red;
    color:white;
}
.logout:hover{
    background:#c0392b;
}

/* MODAL */
.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.9);
}

.modal img{
    display:block;
    margin:5% auto;
    max-width:80%;
}

.close{
    position:absolute;
    top:20px;
    right:30px;
    color:white;
    font-size:40px;
    cursor:pointer;
}
</style>

<script>
function openImage(src){
    document.getElementById("modal").style.display="block";
    document.getElementById("modalImg").src=src;
}

function closeImage(){
    document.getElementById("modal").style.display="none";
}
</script>

</head>

<body>

<h2><?php echo htmlspecialchars($role); ?> Dashboard</h2>

<table>

<tr>
<th>ID</th>
<th>Student</th>
<th>Room</th>
<th>Block</th>
<th>Category</th>
<th>Description</th>
<th>Image</th>
<th>Date</th>
<th>Status</th>
<th>Reply</th>
<th>Action</th>
</tr>

<?php 
if(mysqli_num_rows($q) > 0){ 
while($row = mysqli_fetch_assoc($q)){ 
?>

<tr>

<td><?php echo $row['id']; ?></td>
<td><?php echo htmlspecialchars($row['student_name']); ?></td>
<td><?php echo htmlspecialchars($row['room_no']); ?></td>
<td><?php echo htmlspecialchars($row['block']); ?></td>
<td><?php echo htmlspecialchars($row['category_name']); ?></td>
<td><?php echo htmlspecialchars($row['description']); ?></td>

<td>
<?php if(!empty($row['image'])){ ?>
<img src="../uploads/<?php echo $row['image']; ?>" onclick="openImage(this.src)">
<?php } else { echo "No Image"; } ?>
</td>

<td>
<?php 
echo !empty($row['created_at']) 
? date("d-M-Y", strtotime($row['created_at'])) 
: "N/A"; 
?>
</td>

<td class="<?php echo strtolower($row['status']); ?>">
<?php echo $row['status']; ?>
</td>

<td>
<?php echo !empty($row['reply']) ? $row['reply'] : "No Reply"; ?>
</td>

<td>
<a href="update_status.php?id=<?php echo $row['id']; ?>">
<button class="update">Update</button>
</a>

<a href="reply.php?id=<?php echo $row['id']; ?>">
<button class="reply">Reply</button>
</a>
</td>

</tr>

<?php 
} 
} else { 
?>

<tr>
<td colspan="11">No complaints found</td>
</tr>

<?php } ?>

</table>

<!-- ✅ BOTTOM BUTTONS -->
<div class="bottom-buttons">

    <a href="report.php">
        <button class="report">📊 View Report</button>
    </a>

    <a href="admin_logout.php">
        <button class="logout">Logout</button>
    </a>

</div>

<!-- IMAGE MODAL -->
<div id="modal" class="modal" onclick="closeImage()">
<span class="close">&times;</span>
<img id="modalImg">
</div>

</body>
</html>