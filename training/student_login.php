<?php
// student_login.php
session_start();
include('../db.php');

$logger = require __DIR__ . '/../logger.php';
$logger->info("student_login.php accessed");

$message = "";

// =============================================
// 🔥 LOGIN PROCESS
// =============================================
if (isset($_POST['login'])) {                 

  $logger->info("Login attempt", [
    'enrollment_no' => $_POST['enrollment_no']
  ]);

  $enroll   = trim($_POST['enrollment_no']);
  $password = trim($_POST['password']);

  if ($enroll === "" || $password === "") {
    $message = "All fields are required.";
  } else {

    // =============================================
    // 🔹 FETCH USER
    // =============================================
    $sql = "SELECT enrollment_no, password, status 
                FROM users 
                WHERE enrollment_no = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $enroll);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {

      $user = mysqli_fetch_assoc($result);

      // =============================================
      // 🔥 PASSWORD VERIFY (supports hashed DOB)
      // =============================================
      if (
        password_verify($password, $user['password']) ||
        $password === $user['password']
      ) {

        // =============================================
        // 🔹 FETCH STUDENT PROFILE
        // =============================================
        $stuSql = "SELECT enrollment_no, name, branch
                           FROM student_data
                           WHERE enrollment_no = ?";

        $stuStmt = mysqli_prepare($conn, $stuSql);
        mysqli_stmt_bind_param($stuStmt, "s", $enroll);
        mysqli_stmt_execute($stuStmt);
        $stuResult = mysqli_stmt_get_result($stuStmt);

        if (mysqli_num_rows($stuResult) == 1) {

          $row = mysqli_fetch_assoc($stuResult);

          // ✅ SESSION SET
          $_SESSION['student_enroll'] = $row['enrollment_no'];
          $_SESSION['student_name']   = $row['name'];
          $_SESSION['student_branch'] = $row['branch'];

          $logger->info("Login successful", [
            'enrollment_no' => $enroll
          ]);

          // =============================================
          // 🔹 ACTIVE SESSION FETCH (tumhara old logic)
          // =============================================
          $sesQuery = "SELECT session_value 
                                 FROM session_ref 
                                 WHERE status='Active' 
                                 LIMIT 1";

          $sesResult = mysqli_query($conn, $sesQuery);

          if (mysqli_num_rows($sesResult) == 1) {
            $sesRow = mysqli_fetch_assoc($sesResult);
            $_SESSION['active_session'] = $sesRow['session_value'];
          } else {
            $_SESSION['active_session'] = null;
          }

          // =============================================
          // 🔥 FIRST LOGIN CHECK (MOST IMPORTANT)
          // =============================================
          if ($user['status'] == 'registered') {

            // ✅ status ko active karo
            $updateSql = "UPDATE users SET status='active' WHERE enrollment_no=?";
            $updateStmt = mysqli_prepare($conn, $updateSql);
            mysqli_stmt_bind_param($updateStmt, "s", $enroll);
            mysqli_stmt_execute($updateStmt);

            // ✅ force password change
            header("Location: change_password.php?first=1");
            exit;
          } else {

            // ✅ normal login
            header("Location: student_dashboard.php");
            exit;
          }
        } else {
          $logger->error("Student profile missing", [
            'enrollment_no' => $enroll
          ]);

          $message = "Student profile not found.";
        }
      } else {

        $logger->warning("Invalid password", [
          'enrollment_no' => $enroll
        ]);

        $message = "Invalid Enrollment or Password.";
      }
    } else {

      $logger->warning("User not registered", [
        'enrollment_no' => $enroll
      ]);

      $message = "User not registered.";
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student Registration</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <style>
    :root {
      --bg: #f8fafc;
      --card: #ffffff;
      --text: #111827;
      --muted: #475569;
      --accent: #0ea5e9;
      --border: #e2e8f0;
    }

    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: var(--bg);
      color: var(--text);
     
    }

    /* ===== Registration Card ===== */
    .register-wrapper {
      min-height: calc(100vh - 140px);
      /* header space adjust */
      display: flex;
      align-items: flex-start;
      /* 👈 center ki jagah */
      justify-content: center;
   
     
    }

    .register-card {
      width: 100%;
      max-width: 450px;
      background: var(--card);
      border-radius: 18px;
      padding: 30px 26px;
      box-shadow: 0 10px 25px rgba(14, 165, 233, .18);
      border-top: 5px solid var(--accent);
    }

    .register-card h2 {
      text-align: center;
      margin-bottom: 8px;
      color: #1e293b;
    }

    .register-card p {
      text-align: center;
      font-size: 14px;
      color: var(--muted);
      margin-bottom: 22px;
    }

    /* ===== Form ===== */
    .form-group {
      margin-bottom: 16px;
    }

    .form-group label {
      font-size: 14px;
      font-weight: 600;
      display: block;
      margin-bottom: 6px;
      color: #1e293b;
    }

    .form-group i {
      margin-right: 6px;
      color: var(--accent);
    }

    .form-control {
      width: 100%;
      padding: 10px 12px;
      border-radius: 10px;
      border: 1px solid var(--border);
      font-size: 14px;
      outline: none;
      transition: .25s;
    }

    .form-control:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 2px rgba(14, 165, 233, .15);
    }

    /* ===== Button ===== */
    .btn {
      width: 100%;
      padding: 11px;
      border: none;
      border-radius: 25px;
      background: linear-gradient(135deg, #0ea5e9, #3b82f6);
      color: #fff;
      font-size: 15px;
      font-weight: 600;
      cursor: pointer;
      transition: .3s;
    }

    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 18px rgba(14, 165, 233, .35);
    }

    /* ===== Footer Text ===== */
    .form-footer {
      text-align: center;
      margin-top: 18px;
      font-size: 14px;
    }

    .form-footer a {
      color: var(--accent);
      font-weight: 600;
      text-decoration: none;
    }

    .form-footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <?php include('../header.php');
  include('subHeader.php') ?>
  <?php

  if (isset($_SESSION['login_error'])) {
    echo "<p style='color:red;text-align:center;'>" . $_SESSION['login_error'] . "</p>";
    unset($_SESSION['login_error']);
  }
  ?>
  <?php // include('subheader.php')   
  ?>
  <?php // if(!empty($message):) 
  ?>
  <div class="message error "><?php echo htmlspecialchars($message); ?></div>
  <?php // endif; 
  ?>

  <div class="register-wrapper">
    <div class="register-card">
      <h2>📝 Student Login</h2>

      <form method="post" action="">

        <div class="form-group">
          <label><i class="fas fa-envelope"></i>Enrollment Number</label>
          <input type="text" name="enrollment_no" class="form-control" value="<?php echo isset($_POST['enrollmet_no']) ? htmlspecialchars($_POST['enrollmet_no']) : ''; ?>" required>
        </div>

        <div class="form-group">
          <label><i class="fas fa-lock"></i> Password</label>
          <input type="password" name="password" class="form-control" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';  ?>" required>
        </div>

        <button type="submit" name="login" class="btn">Login</button>

      </form>
    </div>
  </div>

  <?php include('../footer.php'); ?>

</body>

</html>