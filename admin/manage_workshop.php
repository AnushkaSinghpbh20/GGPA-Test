<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

include '../db.php';
include 'sidebar.php';

$logger = require __DIR__ . '/../logger.php';

$logger->info("manage_workshop.php accessed", [
    'admin' => $_SESSION['admin']
]);

// ================= ADD WORKSHOP =================
if(isset($_POST['add_workshop'])){

    $company = $_POST['company'];
    $title = $_POST['title'];
    $venue = $_POST['venue'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $branches = isset($_POST['branch']) && is_array($_POST['branch'])
        ? implode(',', $_POST['branch'])
        : '';

    if(!empty($company)){

        $sql = "INSERT INTO workshops (company, title, branch, venue, description, date, time)
                VALUES ('$company', '$title', '$branches', '$venue', '$description', '$date', '$time')";

        if($conn->query($sql)){
            $_SESSION['success'] = "Workshop added successfully!";
        } else {
            $_SESSION['error'] = $conn->error;
        }

        header("Location: manage_workshop.php");
        exit();

    } else {
        $_SESSION['error'] = "Please select a company!";
        header("Location: manage_workshop.php");
        exit();
    }
}

// ================= DELETE WORKSHOP =================
if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    if($conn->query("DELETE FROM workshops WHERE id = '$id'")){
        $_SESSION['success'] = "Workshop deleted successfully!";
    } else {
        $_SESSION['error'] = $conn->error;
    }

    header("Location: manage_workshop.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Workshops</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background:#f5f7fa; }
.container-box { margin-left:250px; padding:20px; }

.company-logo {
    height:40px;
    width:40px;
    object-fit:cover;
    border-radius:50%;
    margin-left:10px;
}

.logo-preview {
    height:50px;
    width:50px;
    object-fit:cover;
    border-radius:50%;
}

.alert-ajax {
    position:fixed;
    top:20px;
    right:20px;
}
</style>
</head>

<body>
<div class="container-box">

<h2 class="text-center fw-bold mb-4">📌 Manage Workshops</h2>

<?php
if(isset($_SESSION['success'])){
    echo "<div class='alert alert-success alert-ajax'>{$_SESSION['success']}</div>";
    unset($_SESSION['success']);
}
if(isset($_SESSION['error'])){
    echo "<div class='alert alert-danger alert-ajax'>{$_SESSION['error']}</div>";
    unset($_SESSION['error']);
}
?>

<!-- ================= FORM ================= -->
<form method="POST">
<div class="row g-3">

<div class="col-md-6">
<label>Company</label>
<select name="company" class="form-control" id="companySelect" required>
<option value="">Select Company</option>

<?php
$companies = $conn->query("SELECT * FROM company_info ORDER BY company_name ASC");

while($c = $companies->fetch_assoc()){

    $logoPath = !empty($c['logo'])
        ? "../images/company_logo/".$c['logo']
        : "../images/company_logo/default.png";

    echo "<option value='{$c['company_name']}' data-logo='{$logoPath}'>
            {$c['company_name']}
          </option>";
}
?>

</select>
</div>

<div class="col-md-6">
<label>Company Logo</label><br>
<img id="companyLogoPreview"
     class="logo-preview"
     src="../images/company_logo/default.png">
</div>

<div class="col-md-6">
<input type="text" name="title" class="form-control" placeholder="Workshop Title">
</div>

<div class="col-md-6">
<input type="date" name="date" class="form-control" required>
</div>

<div class="col-md-6">
<input type="time" name="time" class="form-control" required>
</div>

<div class="col-md-12">
<textarea name="description" class="form-control" placeholder="Description"></textarea>
</div>

</div>

<button type="submit" name="add_workshop" class="btn btn-primary mt-3">
Add Workshop
</button>
</form>

<!-- ================= TABLE ================= -->
<h3 class="mt-4">Workshop List</h3>

<table class="table table-bordered">
<thead class="table-dark">
<tr>
<th>Company</th>
<th>Title</th>
<th>Date</th>
<th>Time</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php
$res = $conn->query("
SELECT w.*, c.logo
FROM workshops w
LEFT JOIN company_info c ON w.company = c.company_name
ORDER BY w.date DESC
");

while($row = $res->fetch_assoc()){

$logoPath = !empty($row['logo'])
    ? "../images/company_logo/".$row['logo']
    : "../images/company_logo/default.png";

echo "<tr>
<td>
    <img src='{$logoPath}' class='company-logo'>
    {$row['company']}
</td>
<td>{$row['title']}</td>
<td>{$row['date']}</td>
<td>{$row['time']}</td>
<td>
    <a href='?delete={$row['id']}' class='btn btn-danger btn-sm'>Delete</a>
</td>
</tr>";
}
?>

</tbody>
</table>

</div>

<script>
document.getElementById('companySelect').addEventListener('change', function(){
    let logo = this.options[this.selectedIndex].getAttribute('data-logo');
    document.getElementById('companyLogoPreview').src =
        logo ? logo : 'images/company_logo/default.png';
});
</script>

</body>
</html>