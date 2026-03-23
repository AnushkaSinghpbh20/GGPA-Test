<?php
session_start();
include('../db.php');

$logger = require __DIR__ . '/../logger.php';
$logger->info("Student upload page accessed");

// ================= FOLDERS =================
$pendingDir = __DIR__ . "/uploads/student_registration/pending/";
$doneDir    = __DIR__ . "/uploads/student_registration/done/";
$errorDir   = __DIR__ . "/uploads/student_registration/error/";

// create folders if not exist
foreach ([$pendingDir, $doneDir, $errorDir] as $dir) {
    if (!is_dir($dir)) mkdir($dir, 0777, true);
}

// ================= UPLOAD CSV =================
if (isset($_POST['form_submit'])) {

    $fileName = basename($_FILES['csvfile']['name']);
    $tmpName  = $_FILES['csvfile']['tmp_name'];
    $pendingPath = $pendingDir . $fileName;

    if (move_uploaded_file($tmpName, $pendingPath)) {

        $conn->query("INSERT INTO student_file_info(file_name,status)
                      VALUES('$fileName','pending')");

        $logger->info("CSV uploaded", ['file' => $fileName]);

    } else {
        $logger->error("Upload failed", ['file' => $fileName]);
    }
}

// ================= PROCESS CSV =================
if (isset($_GET['process'])) {

    $file_id = intval($_GET['process']);

    $res = $conn->query("SELECT * FROM student_file_info WHERE file_id='$file_id'");
    $file = $res->fetch_assoc();

    if (!$file) die("File not found in DB");

    $filePath = $pendingDir . $file['file_name'];
    $success = true;

    if (($handle = fopen($filePath, "r")) !== FALSE) {

        $row = 0;

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

            if ($row == 0) { $row++; continue; }

            $enrollment_no = $conn->real_escape_string($data[0]);
            $name          = $conn->real_escape_string($data[1]);
            $fathers_name  = $conn->real_escape_string($data[2]);

            $dob_raw = $data[3];
            $dobObj = DateTime::createFromFormat('d/m/Y', $dob_raw);
            $dob = $dobObj ? $dobObj->format('Y-m-d') : null;

            $branch = $conn->real_escape_string($data[4]);
            $addmission_year = $conn->real_escape_string($data[5]);
            $current_year = $conn->real_escape_string($data[6]);

            $exists = $conn->query("SELECT enrollment_no FROM student_data WHERE enrollment_no='$enrollment_no'");

            if ($exists->num_rows == 0) {

                $insert = $conn->query("
                    INSERT INTO student_data
                    (enrollment_no,name,fathers_name,dob,branch,addmission_year,current_year)
                    VALUES
                    ('$enrollment_no','$name','$fathers_name','$dob','$branch','$addmission_year','$current_year')
                ");

                if (!$insert) { $success = false; break; }
            }

            $hashedPassword = password_hash($dob_raw, PASSWORD_DEFAULT);

            $checkUser = $conn->query("SELECT enrollment_no FROM users WHERE enrollment_no='$enrollment_no'");

            if ($checkUser->num_rows == 0) {

                $userInsert = $conn->query("
                    INSERT INTO users (enrollment_no,password,status)
                    VALUES ('$enrollment_no','$hashedPassword','registered')
                ");

                if (!$userInsert) { $success = false; break; }
            }

            $row++;
        }

        fclose($handle);

    } else {
        $success = false;
    }

    if ($success) {

        rename($filePath, $doneDir . $file['file_name']);
        $conn->query("UPDATE student_file_info SET status='done' WHERE file_id='$file_id'");

    } else {

        rename($filePath, $errorDir . $file['file_name']);
        $conn->query("UPDATE student_file_info SET status='error' WHERE file_id='$file_id'");
    }

    header("Location: upload_student_data.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Student CSV Upload</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* ===== BODY ===== */
body{
    margin:0;
    font-family: Arial, sans-serif;
    background:#f4f6f9;
}

/* ===== MAIN ===== */
.main-content{
    margin-left:250px;
    padding:40px;
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

/* Buttons */
.btn-success{
    background:#28a745;
    border:none;
}
.btn-danger{
    background:#dc3545;
    border:none;
}

</style>
</head>

<body>

<?php include('sidebar.php'); ?>

<div class="main-content">

<h1>Upload Student CSV</h1>

<div class="card mb-3">
<a href="download_student_sample.php" class="btn btn-warning">
Download Sample
</a>
</div>

<div class="card">
<form method="post" enctype="multipart/form-data">
<input type="file" name="csvfile" class="form-control mb-3" required>
<button class="btn btn-warning" name="form_submit">Upload</button>
</form>
</div>

<h2 class="mt-5 text-center">Uploaded Files</h2>

<table class="table table-bordered">
<tr>
<th>ID</th>
<th>File Name</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php
$res = $conn->query("SELECT * FROM student_file_info ORDER BY file_id DESC");

while ($r = $res->fetch_assoc()) {

    $baseServer = __DIR__ . "/uploads/student_registration/";
    $baseURL = "uploads/student_registration/";

    if ($r['status'] == 'done') {
        $filePath = $baseURL . "done/" . $r['file_name'];
        $checkPath = $baseServer . "done/" . $r['file_name'];
    } elseif ($r['status'] == 'pending') {
        $filePath = $baseURL . "pending/" . $r['file_name'];
        $checkPath = $baseServer . "pending/" . $r['file_name'];
    } elseif ($r['status'] == 'error') {
        $filePath = $baseURL . "error/" . $r['file_name'];
        $checkPath = $baseServer . "error/" . $r['file_name'];
    } else {
        $filePath = "";
        $checkPath = "";
    }

    echo "<tr>
    <td>{$r['file_id']}</td>
    <td>{$r['file_name']}</td>
    <td>{$r['status']}</td>
    <td>";

    if ($r['status'] == 'pending') {
        echo "<a href='?process={$r['file_id']}' class='btn btn-success btn-sm'>Process</a> ";
    }

    if (!empty($checkPath) && file_exists($checkPath)) {
        echo "<a href='$filePath' class='btn btn-warning btn-sm'>Download</a>";
    } else {
        echo "<span class='text-danger'>File Not Found</span>";
    }

    echo "</td></tr>";
}
?>

</table>

</div>
</body>
</html>