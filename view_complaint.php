<?php
session_start();
include("db.php");

$user_id = $_SESSION['user_id'];

$q = mysqli_query($conn,"
SELECT complaints.*, categories.name AS category_name
FROM complaints
LEFT JOIN categories ON complaints.category_id = categories.id
WHERE user_id='$user_id'
");
?>

<!DOCTYPE html>
<html>
<head>
<style>
body{
font-family:Arial;
background:#ecf0f1;
text-align:center;
}

/* TABLE */
table{
margin:auto;
border-collapse:collapse;
width:90%;
background:white;
}

th,td{
padding:10px;
border:1px solid #ccc;
}

th{
background:#3498db;
color:white;
}

/* STATUS COLORS */
.pending{color:red;}
.processing{color:orange;}
.resolved{color:green;}

/* IMAGE */
img{
border-radius:6px;
transition:0.3s;
}

img:hover{
cursor:pointer;
transform:scale(1.05);
}

/* MODAL */
.modal{
display:none;
position:fixed;
z-index:999;
padding-top:60px;
left:0;
top:0;
width:100%;
height:100%;
background-color:rgba(0,0,0,0.9);
}

.modal-content{
display:block;
margin:auto;
max-width:80%;
max-height:80%;
}

.close{
position:absolute;
top:20px;
right:35px;
color:white;
font-size:40px;
cursor:pointer;
}

/* BUTTON */
button{
padding:10px 20px;
background:#2ecc71;
color:white;
border:none;
border-radius:5px;
cursor:pointer;
}

button:hover{
background:#27ae60;
}
</style>
</head>

<body>

<h2>My Complaints</h2>

<table>
<tr>
<th>Complaint ID</th>
<th>Student ID</th>
<th>Category</th>
<th>Description</th>
<th>Image</th>
<th>Status</th>
<th>Reply</th>
</tr>

<?php if(mysqli_num_rows($q)>0){ 
while($row=mysqli_fetch_assoc($q)){ 
$status_class=strtolower($row['status']);
?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['user_id']; ?></td>
<td><?php echo $row['category_name']; ?></td>
<td><?php echo $row['description']; ?></td>

<td>
<?php if(!empty($row['image'])){ ?>
<img src="uploads/<?php echo $row['image']; ?>" width="80"
onclick="openImage(this.src)">
<?php } else { echo "No Image"; } ?>
</td>

<td class="<?php echo $status_class; ?>">
<?php echo $row['status']; ?>
</td>

<td>
<?php echo !empty($row['reply']) ? $row['reply'] : "No Reply Yet"; ?>
</td>

</tr>

<?php } } else { ?>

<tr>
<td colspan="7">No complaints found</td>
</tr>

<?php } ?>

</table>

<br>

<a href="dashboard.php">
<button>⬅ Back to Dashboard</button>
</a>

<!-- IMAGE POPUP MODAL -->
<div id="imgModal" class="modal" onclick="closeImage()">
<span class="close">&times;</span>
<img class="modal-content" id="modalImg">
</div>

<script>
function openImage(src){
    document.getElementById("imgModal").style.display = "block";
    document.getElementById("modalImg").src = src;
}

function closeImage(){
    document.getElementById("imgModal").style.display = "none";
}
</script>

</body>
</html>