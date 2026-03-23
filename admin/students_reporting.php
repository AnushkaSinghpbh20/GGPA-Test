<?php
session_start();
include("../db.php");

/* ================= GET FILTER VALUES ================= */
$branches = $_GET['branch'] ?? [];
$currentYear = $_GET['year'] ?? "";
$admissionYear = $_GET['admission_year'] ?? "";
$userStatus = $_GET['user_status'] ?? "";
$formStatus = $_GET['form_status'] ?? "";

if(!is_array($branches)){
    $branches = [$branches];
}

$students = [];

if(!empty($currentYear)){

    $branchCondition = "";
    if(!empty($branches) && !in_array("ALL",$branches)){
        $branchList = "'" . implode("','",$branches) . "'";
        $branchCondition = "AND s.branch IN ($branchList)";
    }

    $admissionCondition = "";
    if(!empty($admissionYear)){
        $admissionCondition = "AND s.addmission_year='$admissionYear'";
    }

    $userCondition = "";
    if($userStatus=="active"){
        $userCondition = "AND u.status='Active'";
    }
    if($userStatus=="registered"){
        $userCondition = "AND u.enrollment_no IS NOT NULL";
    }

    $formCondition = "";
    if($formStatus=="submitted"){
        $formCondition = "AND st.enrollment_no IS NOT NULL";
    }
    if($formStatus=="notsubmitted"){
        $formCondition = "AND st.enrollment_no IS NULL";
    }

    $sql="
    SELECT 
        s.enrollment_no,
        s.name,
        s.dob,
        s.branch,
        s.addmission_year,
        s.current_year,
        u.status AS user_status,
        CASE 
            WHEN st.enrollment_no IS NULL THEN 'Form Not Submitted'
            ELSE 'Form Submitted'
        END AS survey_status
    FROM student_data s
    LEFT JOIN users u ON s.enrollment_no=u.enrollment_no
    LEFT JOIN survey_tracker st ON s.enrollment_no=st.enrollment_no
    WHERE s.current_year='$currentYear'
        $admissionCondition
        $branchCondition
        $userCondition
        $formCondition
    ORDER BY s.branch, s.name
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
<title>Student Survey Status</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>
body{
    font-family:'Poppins',sans-serif;
    background:#f4f6f9;
    margin:0;
}

/* ===== Sidebar match admin style ===== */
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

/* ===== Main Content ===== */
.main-content{
    margin-left:240px;
    padding:30px;
}

/* ===== Card Style ===== */
.card{
    background:#fff;
    border:none;
    padding:20px;
    border-radius:15px;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
}

/* ===== Form Controls ===== */
.form-control{
    border-radius:8px;
}

/* ===== Table ===== */
table{
    background:#fff;
    margin-top:20px;
    border-radius:10px;
    overflow:hidden;
}
th{
    background:#1f2937 !important;
    color:#fff;
    text-align:center;
}
td{
    text-align:center;
}

/* ===== Status Colors ===== */
.active{color:#16a34a;font-weight:bold;}
.inactive{color:#dc2626;font-weight:bold;}
.submitted{color:#16a34a;font-weight:bold;}
.notsub{color:#dc2626;font-weight:bold;}

</style>
</head>

<body>

<?php include_once("sidebar.php"); ?>

<div class="main-content">

<h2 class="mb-4">📊 Student Status</h2>

<div class="card shadow-sm">
<form method="GET">
<div class="row">

<!-- Admission Year -->
<div class="col-md-3">
<label>Admission Year</label>
<select name="admission_year" class="form-control">
<option value="">All Years</option>
<?php
for($y=2019;$y<=date("Y");$y++){
    $sel = ($admissionYear==$y)?"selected":"";
    echo "<option value='$y' $sel>$y</option>";
}
?>
</select>
</div>

<!-- Current Year -->
<div class="col-md-3">
<label>Current Year</label>
<select name="year" class="form-control" required>
<option value="">Select Year</option>
<?php
$years=["First Year","Second Year","Final Year"];
foreach($years as $y){
    $sel=($currentYear==$y)?"selected":"";
    echo "<option value='$y' $sel>$y</option>";
}
?>
</select>
</div>

<!-- Branch -->
<div class="col-md-3">
<label>Branch</label>
<select name="branch[]" class="form-control" multiple>
<option value="ALL">All Branch</option>
<?php
$bq=mysqli_query($conn,"SELECT DISTINCT branch FROM student_data");
while($b=mysqli_fetch_assoc($bq)){
    $sel=in_array($b['branch'],$branches)?"selected":"";
    echo "<option value='{$b['branch']}' $sel>{$b['branch']}</option>";
}
?>
</select>
</div>

<!-- User Status -->
<div class="col-md-3">
<label>User Status</label>
<select name="user_status" class="form-control">
<option value="">All</option>
<option value="active" <?= $userStatus=="active"?"selected":"" ?>>Active</option>
<option value="registered" <?= $userStatus=="registered"?"selected":"" ?>>Registered</option>
</select>
</div>

<!-- Form Status -->
<div class="col-md-3 mt-3">
<label>Form Status</label>
<select name="form_status" class="form-control">
<option value="">All</option>
<option value="submitted" <?= $formStatus=="submitted"?"selected":"" ?>>Submitted</option>
<option value="notsubmitted" <?= $formStatus=="notsubmitted"?"selected":"" ?>>Not Submitted</option>
</select>
</div>

<div class="col-md-12 mt-3">
<button class="btn btn-primary w-100">Show Students</button>
</div>

</div>
</form>
</div>

<?php if(!empty($students)){ ?>

<a href="export_students.php?year=<?= urlencode($currentYear) ?>&admission_year=<?= urlencode($admissionYear) ?>&user_status=<?= urlencode($userStatus) ?>&form_status=<?= urlencode($formStatus) ?>&branch=<?= urlencode(implode(',',$branches)) ?>"
class="btn btn-success mt-3">
Download Excel
</a>

<div class="card mt-3">
<table class="table table-bordered">
<thead>
<tr>
<th>Enrollment</th>
<th>Name</th>
<th>DOB</th>
<th>Branch</th>
<th>Admission Year</th>
<th>Current Year</th>
<th>User Status</th>
<th>Survey Status</th>
</tr>
</thead>

<tbody>
<?php foreach($students as $s){ ?>
<tr>
<td><?= $s['enrollment_no'] ?></td>
<td><?= $s['name'] ?></td>
<td><?= $s['dob'] ?></td>
<td><?= $s['branch'] ?></td>
<td><?= $s['addmission_year'] ?></td>
<td><?= $s['current_year'] ?></td>

<td class="<?= strtolower($s['user_status'])=='active'?'active':'inactive' ?>">
<?= $s['user_status'] ?? "Not Registered" ?>
</td>

<td class="<?= $s['survey_status']=='Form Submitted'?'submitted':'notsub' ?>">
<?= $s['survey_status'] ?>
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