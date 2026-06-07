<?php
session_start();
include("db.php");

/* CHECK LOGIN */
if(!isset($_SESSION['user_id'])){
    header("location:login.php");
    exit();
}

/* FETCH CATEGORY */
$cat = mysqli_query($conn,"SELECT * FROM categories");

/* SUBMIT FORM */
if(isset($_POST['submit'])){

    $user_id = $_SESSION['user_id'];
    $desc    = mysqli_real_escape_string($conn, $_POST['description']);
    $cat_id  = $_POST['category'];

    /* ✅ GET ROLE FROM CATEGORY */
    $cat_query = mysqli_query($conn,"SELECT role FROM categories WHERE id='$cat_id'");
    $cat_data  = mysqli_fetch_assoc($cat_query);

    if(!$cat_data){
        die("Category not found!");
    }

    $role = $cat_data['role'];

    /* ✅ GET ADMIN OF THAT ROLE */
    $admin_query = mysqli_query($conn,"SELECT id FROM admin WHERE role='$role' LIMIT 1");
    $admin_data  = mysqli_fetch_assoc($admin_query);

    if(!$admin_data){
        die("No admin found for role: ".$role);
    }

    $admin_id = $admin_data['id'];

    /* IMAGE UPLOAD */
    $imageName = "";

    if(!empty($_FILES['image']['name'])){
        $image = $_FILES['image']['name'];
        $tmp   = $_FILES['image']['tmp_name'];

        $imageName = time() . "_" . $image;

        move_uploaded_file($tmp, "uploads/".$imageName);
    }

    /* ✅ INSERT COMPLAINT */
    $insert = mysqli_query($conn,"
    INSERT INTO complaints(user_id,category_id,description,image,admin_id)
    VALUES('$user_id','$cat_id','$desc','$imageName','$admin_id')
    ");

    if($insert){
        echo "<script>alert('Complaint Submitted Successfully');window.location='view_complaint.php';</script>";
    }else{
        die("Insert Failed: ".mysqli_error($conn));
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Submit Complaint</title>

<style>
body{
    margin:0;
    height:100vh;
    background:
    linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
    url('images/1.jpg') no-repeat center/cover;
    

    display:flex;
    justify-content:center;
    align-items:center;
    font-family:Arial;
    
}

.box{
    background:white;
    padding:25px;
    border-radius:12px;
    width:350px;
    text-align:center;
    box-shadow:0 4px 15px rgba(0,0,0,0.3);
}

h2{
    margin-bottom:15px;
}

input, select, textarea{
    width:100%;
    margin:10px 0;
    padding:12px;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:14px;
    box-sizing:border-box;
}

textarea{
    height:100px;
    resize:none;
}

input[type="file"]{
    padding:8px;
    background:#f9f9f9;
}

button{
    width:100%;
    padding:12px;
    background:#e67e22;
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-weight:bold;
}

button:hover{
    background:#d35400;
}

#preview{
    width:100%;
    margin-top:10px;
    display:none;
    border-radius:8px;
}

input:focus, select:focus, textarea:focus{
    border-color:#e67e22;
    box-shadow:0 0 5px rgba(230,126,34,0.5);
}
</style>

<script>
function previewImage(event){
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('preview');
        output.src = reader.result;
        output.style.display = "block";
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>

</head>

<body>

<div class="box">

<h2>Submit Complaint</h2>

<form method="POST" enctype="multipart/form-data">

<select name="category" required>
<option value="">Select Category</option>

<?php while($c=mysqli_fetch_assoc($cat)){ ?>
<option value="<?php echo $c['id']; ?>">
<?php echo $c['name']; ?>
</option>
<?php } ?>

</select>

<textarea name="description" placeholder="Describe your problem..." required></textarea>

<input type="file" name="image" accept="image/*" onchange="previewImage(event)">

<img id="preview">

<button name="submit">Submit Complaint</button>

</form>

</div>

</body>
</html>