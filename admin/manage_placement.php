<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

include '../db.php';

$logger = require __DIR__ . '/../logger.php';
$logger->info("admin_dashboard.php accessed", [
    'admin' => $_SESSION['admin']
]);

function gpost($k){ return isset($_POST[$k]) ? trim($_POST[$k]) : ''; }

/* ================= DELETE ================= */
if(isset($_GET['delete_placement'])){
    $id = intval($_GET['delete_placement']);

    $logger->info("Delete placement attempt", [
        'admin' => $_SESSION['admin'],
        'placement_id' => $id
    ]);

    if($conn->query("DELETE FROM placements WHERE id=$id")){
        $logger->info("Placement deleted successfully", [
            'admin' => $_SESSION['admin'],
            'placement_id' => $id
        ]);
    } else {
        $logger->error("Placement delete failed", [
            'error' => $conn->error
        ]);
    }

    exit();
}

if(isset($_GET['delete_student'])){
    $id = intval($_GET['delete_student']);

    $logger->info("Delete student placement attempt", [
        'admin' => $_SESSION['admin'],
        'student_id' => $id
    ]);

    if($conn->query("DELETE FROM placement WHERE id=$id")){
        $logger->info("Student placement deleted successfully", [
            'admin' => $_SESSION['admin'],
            'student_id' => $id
        ]);
    } else {
        $logger->error("Student delete failed", [
            'error' => $conn->error
        ]);
    }

    exit();
}

/* ================= ADD ================= */
if(isset($_POST['add_placement'])){

    $logger->info("Add placement attempt", [
        'admin' => $_SESSION['admin'],
        'company' => $_POST['company']
    ]);

    $company = gpost('company');
    $branches = isset($_POST['branch']) ? implode(',', $_POST['branch']) : '';
    $date = gpost('date');
    $time = gpost('time');
    $venue = gpost('venue');

    $logo_name = '';
    if(isset($_FILES['logo']) && $_FILES['logo']['error']==0){
        $logo_name = time().'_'.$_FILES['logo']['name'];
        move_uploaded_file($_FILES['logo']['tmp_name'], 'images/company_logo/'.$logo_name);
    }

    if($conn->query("INSERT INTO placements(company, branch, date, time, venue, image) 
                     VALUES('$company','$branches','$date','$time','$venue','$logo_name')")){

        $logger->info("Placement added successfully", [
            'admin' => $_SESSION['admin'],
            'company' => $company
        ]);

        // ✅ SUCCESS POPUP ADDED (NO LOGIC CHANGE)
        $_SESSION['success'] = "Placement added successfully!";

    } else {
        $logger->error("Placement insert failed", [
            'error' => $conn->error
        ]);
    }

    // exit();
}

if(isset($_POST['add_student'])){

    $logger->info("Add student placement attempt", [
        'admin' => $_SESSION['admin'],
        'student_name' => $_POST['name']
    ]);

    $name = gpost('name');
    $company = gpost('company');
    $package = gpost('package');

    $img_name = '';
    if(isset($_FILES['image']) && $_FILES['image']['error']==0){
        $img_name = time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], 'images/company_logo/'.$img_name);
    }

    if($conn->query("INSERT INTO placement(name, company, package, image_url) 
                     VALUES('$name','$company','$package','$img_name')")){

        $logger->info("Student placement added successfully", [
            'admin' => $_SESSION['admin'],
            'student_name' => $name
        ]);

    } else {
        $logger->error("Student insert failed", [
            'error' => $conn->error
        ]);
    }

    exit();
}

/* ================= FETCH DATA ================= */
$companies = [];
$cres = $conn->query("SELECT company_id, company_name, logo FROM company_info ORDER BY company_name ASC");
while($r=$cres->fetch_assoc()) $companies[]=$r;

$placements = [];
$res = $conn->query("SELECT * FROM placements ORDER BY date ASC");
while($r=$res->fetch_assoc()) $placements[]=$r;

$students = [];
$res2=$conn->query("SELECT * FROM placement ORDER BY package DESC");
while($r=$res2->fetch_assoc()) $students[]=$r;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Dashboard - College Placements</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{font-family:'Poppins',sans-serif;background:#f4f6f9;}
.main-content{margin-left:240px;padding:30px;}
.logo-thumb{width:60px;height:60px;object-fit:contain;}
.card-form{border-radius:15px;padding:15px;box-shadow:0 4px 15px rgba(0,0,0,0.1);background:#fff;margin-bottom:20px;}
.sidebar{position:fixed;top:0;left:0;width:220px;height:100%;background:#1f2937;padding-top:20px;}
.sidebar a{display:block;color:#fff;padding:15px 20px;text-decoration:none;}
</style>

<script>
function showSection(section){
    document.getElementById('placementSection').style.display='none';
    document.getElementById('studentSection').style.display='none';
    document.getElementById(section).style.display='block';
}

function showLogo(){
    let select = document.getElementById('companySelect');
    let logo = select.options[select.selectedIndex].getAttribute('data-logo');
    if(logo){
        document.getElementById('companyLogo').src = 'images/company_logo/' + logo;
    } else {
        document.getElementById('companyLogo').src = '';
    }
}
</script>
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="main-content">
<h2 class="mb-4">📊 Admin Dashboard - College Placements</h2>

<!-- ✅ SUCCESS POPUP -->
<?php
if(isset($_SESSION['success'])){
    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            ".$_SESSION['success']."
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
          </div>";
    unset($_SESSION['success']);
}
?>

<div class="mb-4">
<button class="btn btn-primary me-2" onclick="showSection('placementSection')">Manage Placements</button>
<button class="btn btn-success" onclick="showSection('studentSection')">Manage Students</button>
</div>

<!-- ================= Placements ================= -->
<div id="placementSection">

<div class="card-form">
<h5>Add New Placement</h5>
<form method="post" enctype="multipart/form-data" class="row g-2">

<div class="col-md-4">
<label>Company</label>
<select name="company" id="companySelect" class="form-select" required onchange="showLogo()">
<option value="">Select Company</option>

<?php foreach($companies as $c){ ?>
<option value="<?=htmlspecialchars($c['company_name'])?>" 
        data-logo="<?=htmlspecialchars($c['logo'])?>">
    <?=htmlspecialchars($c['company_name'])?>
</option>
<?php } ?>

</select>
</div>

<div class="col-md-2">
<label>Logo</label><br>
<img id="companyLogo" src="" class="logo-thumb" style="border:1px solid #ccc;">
</div>

<div class="col-md-4">
<label>Branch</label><br>
<input type="checkbox" name="branch[]" value="CSE"> CSE
<input type="checkbox" name="branch[]" value="ELEX"> ELEX
<input type="checkbox" name="branch[]" value="MOM"> MOM
</div>

<div class="col-md-3">
<label>Date</label>
<input type="date" name="date" class="form-control" required>
</div>

<div class="col-md-2">
<label>Time</label>
<select name="time" class="form-select" required>
<option value="">Select Time</option>
<?php 
$times = ['9:00 AM','10:00 AM','11:00 AM','12:00 PM','1:00 PM','2:00 PM','3:00 PM','4:00 PM','5:00 PM'];
foreach($times as $t){
    echo "<option value='$t'>$t</option>";
}
?>
</select>
</div>

<div class="col-md-3">
<label>Venue</label>
<input type="text" name="venue" class="form-control" required>
</div>

<div class="col-md-2 align-self-end">
<button type="submit" name="add_placement" class="btn btn-primary w-100">Add</button>
</div>

</form>
</div>

<!-- Table -->
<div class="card-form">
<h5>Upcoming Placement Drives</h5>
<table class="table table-bordered mt-3">
<thead class="table-dark">
<tr>
<th>Logo</th>
<th>Company</th>
<th>Branch</th>
<th>Date</th>
<th>Time</th>
<th>Venue</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php foreach($placements as $p){ ?>
<tr>           
<td>
<?php 
$logo_path = !empty($p['image']) ? '../images/company_logo/'.$p['image'] : '';
if($logo_path && file_exists($logo_path))
    echo '<img src="'.$logo_path.'" class="logo-thumb">';
else
    echo "No Logo";
?>
</td>
<td><?=htmlspecialchars($p['company'])?></td>
<td><?=htmlspecialchars($p['branch'])?></td>
<td><?=htmlspecialchars($p['date'])?></td>
<td><?=htmlspecialchars($p['time'])?></td>
<td><?=htmlspecialchars($p['venue'])?></td>
<td>
<a href="?delete_placement=<?=$p['id']?>" class="btn btn-danger btn-sm">Delete</a>
</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>

</div>

<!-- ================= Students ================= -->
<div id="studentSection" style="display:none;">

<div class="card-form">
<h5>Add Student</h5>
<form method="post" enctype="multipart/form-data" class="row g-2">
<input type="text" name="name" placeholder="Name" class="form-control col-md-3">
<input type="text" name="company" placeholder="Company" class="form-control col-md-3">
<input type="text" name="package" placeholder="Package" class="form-control col-md-2">
<input type="file" name="image" class="form-control col-md-2">
<button type="submit" name="add_student" class="btn btn-success col-md-2">Add</button>
</form>
</div>

</div>

</div>
</body>
</html>