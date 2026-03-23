<?php
session_start();
include '../db.php'; // apna database connection file

if(isset($_POST['login'])){
    $username = trim($_POST['username']);
    $password_raw = $_POST['password']; // plain password from form
    $password_hash = md5($password_raw); // current DB is using MD5

    // Prepared statement to avoid SQL injection
    $stmt = $conn->prepare("SELECT password FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows === 1){
        $stmt->bind_result($db_password);
        $stmt->fetch();

        if($db_password === $password_hash){
            // Login success
            session_regenerate_id(true); // security: regenerate session id
            $_SESSION['admin'] = $username;
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "❌ Invalid username or password!";
        }
    } else {
        $error = "❌ Invalid username or password!";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">
  <div class="card p-4 shadow" style="width:400px;">
    <h3 class="text-center mb-3">🔐 Admin Login</h3>
    <?php if(isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
    <form method="POST">
      <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button class="btn btn-primary w-100" type="submit" name="login">Login</button>
    </form>
  </div>
</body>
</html>
