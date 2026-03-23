<?php
session_start();
include '../db.php';

if (!isset($_SESSION['student_enroll'])) {
    header("Location: student_login.php");
    exit;
}

$enroll = $_SESSION['student_enroll'];
$activeSession = $_SESSION['active_session'] ?? null;

// 🔹 student data
$query = "SELECT enrollment_no, name, branch, addmission_year
          FROM student_data
          WHERE enrollment_no = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $enroll);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

// 🔹 check already submitted
$alreadySubmitted = false;

if($activeSession != null){
    $checkSql = "SELECT * FROM survey_tracker 
                 WHERE enrollment_no=? 
                 AND session_value=? 
                 AND status='Form Submitted'";

    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ss", $enroll, $activeSession);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    $alreadySubmitted = ($checkResult->num_rows > 0);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Profile</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background: #f8fafc;
    color: #1e293b;
}

h1 {
    text-align: center;
    margin: 30px 0;
    font-weight: 600;
}

.profile-container {
    max-width: 600px;
    margin: auto;
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    transition: 0.3s;
    margin-bottom: 50px;
}

.profile-container:hover {
    box-shadow: 0 10px 28px rgba(14,165,233,0.3);
}

.profile-item {
    margin-bottom: 18px;
    font-size: 1rem;
}

.profile-item strong {
    display: inline-block;
    width: 170px;
    color: #0ea5e9;
}

.btn-group {
    text-align: center;
    margin-top: 25px;
}

.btn {
    padding: 10px 18px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
    margin: 5px;
    display: inline-block;
    transition: 0.3s;
    border:none;
    cursor:pointer;
}

.btn-fill {
    background: #0ea5e9;
    color: #fff;
}

.btn-fill:hover {
    background: #0284c7;
}

.btn-success {
    background: #16a34a;
    color: #fff;
}

.btn-logout {
    background: #ef4444;
    color: #fff;
}

.btn-logout:hover {
    background: #dc2626;
}

.no-session{
    text-align:center;
    color:red;
    font-weight:bold;
}
</style>
</head>
<body>

<?php include('../header.php'); ?>
<?php include('subheader.php'); ?>

<h1><i class="fas fa-user-graduate"></i> Student Profile</h1>

<div class="profile-container">

    <div class="profile-item">
        <strong>Name:</strong> <?= htmlspecialchars($student['name']) ?>
    </div>

    <div class="profile-item">
        <strong>Enrollment No:</strong> <?= htmlspecialchars($student['enrollment_no']) ?>
    </div>

    <div class="profile-item">
        <strong>Branch:</strong> <?= htmlspecialchars($student['branch']) ?>
    </div>

    <div class="profile-item">
        <strong>Admission Session:</strong> <?= htmlspecialchars($student['addmission_year']) ?>
    </div>

    <div class="profile-item">
        <strong>Active Survey Session:</strong> 
        <?= $activeSession ?? "Not Active" ?>
    </div>

    <div class="btn-group">

        <!-- 🔥 BUTTON LOGIC -->

        <?php if($activeSession == null): ?>

            <p class="no-session">No Active Session Right Now</p>

        <?php elseif($alreadySubmitted): ?>

            <button class="btn btn-success">
                <i class="fas fa-check"></i> Feedback Submitted
            </button>

        <?php else: ?>

            <a href="review_page.php" class="btn btn-fill">
                <i class="fas fa-pen"></i> Fill Feedback Form
            </a>

        <?php endif; ?>

        <br>

        <a href="Studentlogout.php" class="btn btn-logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>

    </div>

</div>

<?php include('../footer.php'); ?>
</body>
</html>