<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

include '../db.php';       
include 'sidebar.php';

// ✅ LOGGER ADD
$logger = require __DIR__ . '/../logger.php';
$logger->info("manage_faculty.php accessed");

// ADD FACULTY
if(isset($_POST['add'])){

    $logger->info("Add faculty attempt", [
        'admin' => $_SESSION['admin'],
        'name' => $_POST['name']
    ]);

    $name = $_POST['name'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $designation = $_POST['designation'];
    $date_of_joining = $_POST['date_of_joining'];
    $qualification = $_POST['qualification'];
    $status = $_POST['status'];

    $photo = '';

    // Calculate Experience automatically
    $join = new DateTime($date_of_joining);
    $today = new DateTime();
    $exp_interval = $today->diff($join);
    $experience = $exp_interval->y;

    if(isset($_FILES['photo']) && $_FILES['photo']['error']==0){
        $photo = time().'_'.$_FILES['photo']['name'];
        move_uploaded_file($_FILES['photo']['tmp_name'], '../images/faculty/'.$photo);
    }

    $sql = "INSERT INTO faculty
    (name,email,department,designation,date_of_joining,experience,qualification,status,photo)
    VALUES
    ('$name','$email','$department','$designation','$date_of_joining','$experience','$qualification','$status','$photo')";

    if($conn->query($sql)){

        $logger->info("Faculty added successfully", [
            'admin' => $_SESSION['admin'],
            'name' => $name
        ]);

        $success = "Faculty added successfully!";
    } else {

        $logger->error("Faculty insert failed", [
            'error' => $conn->error
        ]);

        $error = "Error : ".$conn->error;
    }
}

// DELETE FACULTY
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);

    $logger->info("Delete faculty attempt", [
        'admin' => $_SESSION['admin'],
        'faculty_id' => $id
    ]);

    if($conn->query("DELETE FROM faculty WHERE id=$id")){

        $logger->info("Faculty deleted successfully", [
            'admin' => $_SESSION['admin'],
            'faculty_id' => $id
        ]);

    } else {

        $logger->error("Faculty delete failed", [
            'error' => $conn->error
        ]);
    }

    header("Location: manage_faculty.php");
    exit();
}

// FETCH FACULTY
$result = $conn->query("SELECT * FROM faculty ORDER BY name ASC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Faculty</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f4f6f9;
    font-family:Poppins;
}
.main-content{
    margin-left:240px;
    padding:30px;
}
.card{
    padding:20px;
    margin-bottom:25px;
    border-radius:10px;
}
.faculty-img{
    height:50px;
    width:50px;
    object-fit:cover;
    border-radius:50%;
}
</style>
</head>

<body>

<div class="main-content">

<h2 class="mb-4">Manage Faculty</h2>

<?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
<?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

<!-- ADD FACULTY -->
<div class="card">
<h5>Add Faculty</h5>

<form method="POST" enctype="multipart/form-data" class="row g-3">

<div class="col-md-4">
<label class="form-label">Faculty Name</label>
<input type="text" name="name" class="form-control" required>
</div>

<div class="col-md-4">
<label class="form-label">Email</label>
<input type="email" name="email" class="form-control">
</div>

<div class="col-md-4">
<label class="form-label">Department</label>
<select name="department" class="form-control" required>
<option value="">Select Department</option>
<option>Computer Science</option>
<option>Electronics Engineering</option>
<option>Modern Office Management</option>
<option>Accountancy & Taxation</option>
<option>Applied Science</option>
</select>
</div>

<div class="col-md-4">
<label class="form-label">Designation</label>
<select name="designation" class="form-control" required>
<option value="">Select Designation</option>
<option>Principal</option>
<option>HOD</option>
<option>Lecturer</option>
<option>Guest Lecturer</option>
</select>
</div>

<div class="col-md-4">
<label class="form-label">Department Joining Date</label>
<input type="date" name="date_of_joining" class="form-control" required>
</div>

<div class="col-md-4">
<label class="form-label">Highest Qualification</label>
<input type="text" name="qualification" class="form-control" placeholder="Enter Highest Qualification">
</div>

<div class="col-md-4">
<label class="form-label">Status</label>
<select name="status" class="form-control">
<option value="Active">Active</option>
<option value="Transferred">Transferred</option>
<option value="Retired">Retired</option>
</select>
</div>

<div class="col-md-4">
<label class="form-label">Photo</label>
<input type="file" name="photo" class="form-control">
</div>

<div class="col-md-4">
<button class="btn btn-primary w-100" name="add">Add Faculty</button>
</div>

</form>
</div>

<!-- FACULTY TABLE -->
<div class="card">
<h5>Faculty List</h5>

<table class="table table-bordered mt-3">
<thead>
<tr>
<th>Photo</th>
<th>Name</th>
<th>Email</th>
<th>Department</th>
<th>Designation</th>
<th>Experience (Years)</th>
<th>Joining Date</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php while($row = $result->fetch_assoc()){ ?>
<tr>

<td>
<?php if($row['photo']){ ?>
<img src="uploads/faculty/<?php echo $row['photo']; ?>" class="faculty-img">
<?php } else { echo "No Photo"; } ?>
</td>

<td><?php echo $row['name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['department']; ?></td>
<td><?php echo $row['designation']; ?></td>
<td><?php echo $row['experience']; ?></td>
<td><?php echo $row['date_of_joining']; ?></td>
<td><?php echo $row['status']; ?></td>

<td>
<a href="?delete=<?php echo $row['id']; ?>" 
class="btn btn-danger btn-sm"
onclick="return confirm('Delete faculty?')">
Delete
</a>
</td>

</tr>
<?php } ?>

<?php if($result->num_rows==0){ ?>
<tr>
<td colspan="9" class="text-center">No faculty added yet</td>
</tr>
<?php } ?>

</tbody>
</table>

</div>

</div>
</body>
</html>