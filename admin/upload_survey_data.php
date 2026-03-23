<?php
session_start();

include('../db.php');

// upload.php

$logger = require __DIR__ . '/../logger.php';

// Page accessed
$logger->info("Upload page accessed");

if (isset($_POST['upload'])) {

    if (!isset($_FILES['csv'])) {
        $logger->error("No file selected");
        die("No file selected");
    }

    $fileName = $_FILES['csv']['name'];
    $tmpName  = $_FILES['csv']['tmp_name'];

    $logger->info("File upload attempt", ['file' => $fileName]);

    $targetPath = __DIR__ . '/uploads/survey_data/pending/' . $fileName;

    if (move_uploaded_file($tmpName, $targetPath)) {
        $logger->info("File moved to pending folder", [
            'file' => $fileName,
            'path' => $targetPath
        ]);
    } else {
        $logger->error("File move failed", [
            'file' => $fileName
        ]);
    }
}



// Folders
$pendingDir = "uploads/survey_data/pending/";
$doneDir    = "uploads/survey_data/done/";
$errorDir   = "uploads/survey_data/error/";
$deletedDir = "uploads/survey_data/deleted/";

foreach([$pendingDir,$doneDir,$errorDir,$deletedDir] as $dir){
    if(!is_dir($dir)) mkdir($dir,0777,true);
}

// ---------- Upload CSV ----------
if(isset($_POST['form_submit'])){
    $sessionYear = $_POST['session_year'];
    $fileName = basename($_FILES["csvfile"]["name"]);
    $pendingPath = $pendingDir.$fileName;

    if(move_uploaded_file($_FILES["csvfile"]["tmp_name"], $pendingPath)){
        $check = $conn->query("SELECT * FROM file_info WHERE file_name='$fileName' AND session_year='$sessionYear'");
        if($check->num_rows==0){
            $insert = $conn->query("INSERT INTO file_info (file_name, session_year, status) VALUES ('$fileName','$sessionYear','pending')");
            if(!$insert) die("Error: ".$conn->error);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">  
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel - Upload</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<style>

/* ===== BODY ===== */
body{
    font-family: 'Segoe UI', sans-serif;
    background:#f4f7fc;
    margin:0;
    display:flex;
}


/* Logout */
.logout-btn{
    background:#ff4d4d;
    color:white;
    border:none;
    padding:10px;
    border-radius:8px;
    font-weight:bold;
    margin-top:auto;
    text-align:center;
    text-decoration:none;
}

.logout-btn:hover{
    background:#ff3333;
}

/* ===== MAIN CONTENT ===== */
.main-content{
    margin-left:250px;
    padding:40px;
    flex:1;
}

/* ===== TITLE ===== */
h1{
    text-align:center;
    font-weight:700;
    color:#0a3d62;
    margin-bottom:30px;
}

/* ===== CARD ===== */
.card{
    background:#fff;
    padding:25px;
    border-radius:15px;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
    max-width:500px;
    margin:0 auto;
}

/* ===== FORM ===== */
.form-control{
    border-radius:10px;
    border:1px solid #ccc;
}

.form-control:focus{
    border-color:#0a3d62;
    box-shadow:0 0 5px rgba(10,61,98,0.3);
}

/* File Button */
.form-control::file-selector-button{
    background:#0a3d62;
    color:white;
    border:none;
    padding:.5rem 1rem;
    border-radius:6px;
    cursor:pointer;
}

/* ===== BUTTON ===== */
.btn-warning{
    background:#0a3d62;
    border:none;
    width:100%;
    font-weight:bold;
    border-radius:10px;
}

.btn-warning:hover{
    background:#084b82;
}

/* ===== TABLE ===== */
table{
    margin-top:30px;
    background:#fff;
    border-radius:10px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

th{
    background:#0a3d62;
    color:#fff;
}

td{
    vertical-align:middle;
}

/* Buttons inside table */
.btn-success{
    background:#28a745;
    border:none;
}
.btn-danger{
    background:#dc3545;
    border:none;
}
.btn-warning.btn-sm{
    background:#ffc107;
    color:#000;
}

/* ===== RESPONSIVE ===== */
@media(max-width:768px){
    .sidebar{
        display:none;
    }
    .main-content{
        margin-left:0;
    }
}

</style>
</head>

<body>
<?php include('sidebar.php');?>

<!-- main content  -->
<div class="main-content">

<h1>Insert Data</h1>

<div class="card shadow-lg">
<form action="" method="post" enctype="multipart/form-data">

<div class="mb-3">
<label class="form-label">Select Session</label>
<select class="form-control" name="session_year" required>
<option value="2025">2025</option>
<option value="2024">2024</option>
<option value="2023">2023</option>
</select>
</div>

<div class="mb-3">
<label for="csv" class="form-label">Upload CSV File</label>
<input class="form-control" type="file" name="csvfile" id="csv" required>
</div>

<button type="submit" class="btn btn-warning" name="form_submit">Import File</button>

</form>
</div>

<h2 class="mt-5 text-center">Uploaded Files</h2>

<table class="table table-bordered">
<thead>
<tr>
<th>File ID</th>
<th>File Name</th>
<th>Session</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>

<tbody>
<?php
$result = $conn->query("SELECT * FROM file_info ORDER BY file_id DESC");
while($row = $result->fetch_assoc()){
    $status = $row['status'];
    echo "<tr>
        <td>{$row['file_id']}</td>
        <td>{$row['file_name']}</td>
        <td>{$row['session_year']}</td>
        <td>$status</td>
        <td>";

    if($status == 'pending'){
        echo "<a href='process.php?process={$row['file_id']}' class='btn btn-success btn-sm'>Process</a> "; 
        echo "<a href='move.php?delete={$row['file_id']}' class='btn btn-danger btn-sm'>Delete</a>";
    } elseif($status == 'done'){
        echo "<a href='move.php?move={$row['file_id']}' class='btn btn-danger btn-sm'>Move</a> ";
        echo "<a href='move.php?delete={$row['file_id']}' class='btn btn-danger btn-sm'>Delete</a>";
    } elseif($status == 'error'){
        echo "<a href='move.php?retry_move={$row['file_id']}' class='btn btn-warning btn-sm'>Retry Move</a> ";
        echo "<a href='move.php?delete={$row['file_id']}' class='btn btn-danger btn-sm'>Delete</a>";
    } elseif($status == 'moved'){ 
        echo "<span class='text-success'>Moved</span> ";
        echo "<a href='delete.php?delete={$row['file_id']}' class='btn btn-danger btn-sm'>Delete</a>";
    }

    echo "</td></tr>";
}
?>
</tbody>
</table>

</div>

</body>
</html>