<?php
session_start();
include("../db.php");

$currentYear = $_GET['current_year'] ?? "";
$branch = $_GET['branch'] ?? "";

$students = [];

/* ================= PROMOTION LOGIC ================= */

if(isset($_GET['promote'])){

$enroll = $_GET['promote'];

$get = mysqli_query($conn,"
SELECT current_year 
FROM student_data 
WHERE enrollment_no='$enroll'
");

$row = mysqli_fetch_assoc($get);

$current = $row['current_year'];

$newYear = $current;

if($current=="First Year"){
$newYear="Second Year";
}
elseif($current=="Second Year"){
$newYear="Final Year";
}
elseif($current=="Final Year"){
$newYear="Promoted";
}

mysqli_query($conn,"
UPDATE student_data 
SET current_year='$newYear'
WHERE enrollment_no='$enroll'
");

header("Location: promote_students.php?current_year=$currentYear&branch=$branch");
exit;

}

/* ================= FETCH STUDENTS ================= */

if($currentYear!=""){

$branchCondition="";

if($branch!="" && $branch!="ALL"){
$branchCondition="AND branch='$branch'";
}

$sql="
SELECT *
FROM student_data
WHERE current_year='$currentYear'
$branchCondition
ORDER BY branch,name
";

$res=mysqli_query($conn,$sql);

while($row=mysqli_fetch_assoc($res)){
$students[]=$row;
}

}

?>

<!DOCTYPE html>
<html>
<head>
<title>Promote Students</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* ===== BODY ===== */
body{
    font-family:'Poppins',sans-serif;
    background:#f4f6f9;
    margin:0;
}

/* ===== SIDEBAR ===== */
.sidebar{
    position:fixed;
    top:0;
    left:0;
    width:220px;
    height:100%;
    background:#1f2937;
    padding-top:20px;
}
.sidebar a{
    display:block;
    color:#fff;
    padding:15px 20px;
    text-decoration:none;
}
.sidebar a:hover{
    background:#374151;
}

/* ===== MAIN ===== */
.main-content{
    margin-left:240px;
    padding:30px;
}

/* ===== CARD ===== */
.card{
    background:#fff;
    border:none;
    padding:20px;
    border-radius:15px;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
}

/* ===== FORM ===== */
.form-control{
    border-radius:8px;
}

/* ===== TABLE ===== */
table{
    margin-top:20px;
    background:#fff;
    border-radius:10px;
    overflow:hidden;
}
th{
    background:#1f2937;
    color:#fff;
    text-align:center;
}
td{
    text-align:center;
}

/* ===== STATUS ===== */
.promoted{
    color:#16a34a;
    font-weight:bold;
}

/* ===== BUTTON ===== */
.btn-success{
    border-radius:20px;
    padding:5px 15px;
    font-weight:600;
}

</style>

</head>

<body>

<?php include_once("sidebar.php"); ?>

<div class="main-content">

<h2 class="mb-4">🎓 Promote Students</h2>

<!-- ================= FORM ================= -->
<div class="card shadow-sm">

<form method="GET">

<div class="row">

<div class="col-md-4">
<label>Select Current Year</label>
<select name="current_year" class="form-control" required>
<option value="">Select Year</option>
<option value="First Year">First Year</option>
<option value="Second Year">Second Year</option>
<option value="Final Year">Final Year</option>
</select>
</div>

<div class="col-md-4">
<label>Select Branch</label>
<select name="branch" class="form-control">
<option value="ALL">All Branch</option>
<?php
$bq=mysqli_query($conn,"SELECT DISTINCT branch FROM student_data");
while($b=mysqli_fetch_assoc($bq)){
echo "<option value='{$b['branch']}'>{$b['branch']}</option>";
}
?>
</select>
</div>

<div class="col-md-4 mt-4">
<button class="btn btn-primary w-100">Show Students</button>
</div>

</div>

</form>

</div>

<!-- ================= TABLE ================= -->
<?php if(!empty($students)){ ?>

<div class="card mt-4">

<table class="table table-bordered">
<thead>
<tr>
<th>Enrollment</th>
<th>Name</th>
<th>Branch</th>
<th>Current Year</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php foreach($students as $s){ ?>
<tr>

<td><?= $s['enrollment_no'] ?></td>
<td><?= $s['name'] ?></td>
<td><?= $s['branch'] ?></td>

<td class="promoted">
<?= $s['current_year'] ?>
</td>

<td>

<?php if($s['current_year']!="Promoted"){ ?>

<a href="?promote=<?= $s['enrollment_no'] ?>&current_year=<?= $currentYear ?>&branch=<?= $branch ?>"
class="btn btn-success btn-sm">
Promote
</a>

<?php } else { ?>

<span class="badge bg-success">Completed</span>

<?php } ?>

</td>

</tr>
<?php } ?>

</tbody>
</table>                 

</div>

<?php } ?>

</div>

</body>
</html>