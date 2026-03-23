<?php
session_start();
include "../db.php";
$logger = require __DIR__ . '/../logger.php';

$logger->info("Change password page accessed");

if(!isset($_SESSION['student_enroll'])){
    $logger->warning("Unauthorized access attempt to change_password page");
    header("Location: student_login.php");
    exit;
}

$msg = "";
$isFirst = isset($_GET['first']);

if(isset($_POST['change_pass'])){

    $enroll  = $_SESSION['student_enroll'];
    $oldpass = $_POST['old_password'];
    $newpass = $_POST['new_password'];

    $logger->info("Password change request received",[
        "student_enroll"=>$enroll
    ]);

    // get current password
    $sql = "SELECT password FROM users WHERE enrollment_no=?";
    $stmt = mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt,"s",$enroll);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($res);

    if(password_verify($oldpass,$user['password'])){

        $newHash = password_hash($newpass,PASSWORD_DEFAULT);

        // update password + status active
        $update = "UPDATE users 
                   SET password=?, status='active' 
                   WHERE enrollment_no=?";
        $ustmt = mysqli_prepare($conn,$update);
        mysqli_stmt_bind_param($ustmt,"ss",$newHash,$enroll);
        mysqli_stmt_execute($ustmt);

        $logger->info("Password changed successfully",[
            "student_enroll"=>$enroll
        ]);

        header("Location: student_dashboard.php");
        exit;

    } else {

        $logger->warning("Incorrect old password entered",[
            "student_enroll"=>$enroll
        ]);

        $msg = "Old password incorrect ❌";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Change Password</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

<h3>
<?php if($isFirst) echo "First Login - Change Password"; else echo "Change Password"; ?>
</h3>

<?php if($msg!="") echo "<p style='color:red;'>$msg</p>"; ?>

<form method="post">
<input type="password" name="old_password" placeholder="Old Password" class="form-control mb-2" required>
<input type="password" name="new_password" placeholder="New Password" class="form-control mb-2" required>
<button class="btn btn-primary" name="change_pass">Change Password</button>
</form>

</body>
</html>