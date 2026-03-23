<?php
session_start();
include('../db.php');
$logger = require __DIR__ . '/../logger.php';

$logger->info("SessionManagement page opened");

$message = "";

/* ================= INSERT SESSION ================= */
if(isset($_POST['add_session'])){

    $session_value = $_POST['session_value'];
    $status = $_POST['status'];

    if($status == 'Active'){
        $conn->query("UPDATE session_ref SET status='Inactive'");
    }

    $stmt = $conn->prepare("INSERT INTO session_ref (session_value,status) VALUES (?,?)");
    $stmt->bind_param("ss",$session_value,$status);

    if($stmt->execute()){
        $message = "Session inserted successfully";
    }else{
        $message = "Insert failed";
    }
}

/* ================= TOGGLE ================= */
if(isset($_GET['toggle'])){

    $id = $_GET['toggle'];

    $get = $conn->query("SELECT status FROM session_ref WHERE session_id=$id");
    $row = $get->fetch_assoc();

    $newStatus = ($row['status']=='Active') ? 'Inactive' : 'Active';

    if($newStatus == 'Active'){
        $conn->query("UPDATE session_ref SET status='Inactive'");
    }

    $conn->query("UPDATE session_ref SET status='$newStatus' WHERE session_id=$id");

    header("Location: session_management.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Session Management</title>

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
    max-width:600px;
    margin:auto;
}

/* ===== INPUT ===== */
.form-control{
    border-radius:8px;
}

/* ===== TABLE ===== */
table{
    margin-top:25px;
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

/* ===== BUTTONS ===== */
.btn-toggle{
    padding:5px 15px;
    border-radius:20px;
    font-weight:600;
    text-decoration:none;
}

.active-btn{
    background:#16a34a;
    color:#fff;
}

.inactive-btn{
    background:#dc2626;
    color:#fff;
}

</style>
</head>

<body>

<?php include_once('sidebar.php') ?>

<div class="main-content">

<h2 class="mb-4">📌 Session Management</h2>

<?php if($message!=""){ ?>
<div class="alert alert-success">
    <?= $message ?>
</div>
<?php } ?>

<!-- ================= FORM ================= -->
<div class="card shadow-sm">

<form method="post">

<div class="mb-3">
<label>Session Value</label>
<input type="text" name="session_value" class="form-control" placeholder="e.g. 2025-26" required>
</div>

<div class="mb-3">
<label>Status</label>
<select name="status" class="form-control">
<option value="Active">Active</option>
<option value="Inactive">Inactive</option>
</select>
</div>

<button type="submit" name="add_session" class="btn btn-primary w-100">
Add Session
</button>

</form>

</div>

<!-- ================= TABLE ================= -->
<h4 class="mt-5">Session List</h4>

<div class="card mt-3">

<table class="table table-bordered">
<thead>
<tr>
<th>ID</th>
<th>Session</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php
$result = $conn->query("SELECT * FROM session_ref ORDER BY session_id DESC");

while($row = $result->fetch_assoc()){
?>

<tr>
<td><?= $row['session_id'] ?></td>
<td><?= $row['session_value'] ?></td>

<td>
<?php if($row['status']=='Active'){ ?>
<span class="badge bg-success">Active</span>
<?php }else{ ?>
<span class="badge bg-danger">Inactive</span>
<?php } ?>
</td>

<td>
<a href="?toggle=<?= $row['session_id'] ?>"
class="btn-toggle <?= ($row['status']=='Active')?'active-btn':'inactive-btn' ?>">
Toggle
</a>
</td>

</tr>

<?php } ?>

</tbody>
</table>

</div>

</div>

</body>
</html>