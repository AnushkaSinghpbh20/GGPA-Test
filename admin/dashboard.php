<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | GGP Amethi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <style>
    body {
      background: #f4f6f9;
      font-family: 'Poppins', sans-serif;
    }

    .dashboard-header {
      text-align: center;
      margin-bottom: 40px;
    }

    .dashboard-header h1 {
      font-weight: 700;
      color: #1f2937;
    }

    .card-dashboard {
      border-radius: 20px;
      transition: all 0.3s ease;
      cursor: pointer;
      background: linear-gradient(135deg, #6C5CE7 0%, #00CEC9 100%);
      color: #fff;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      text-align: center;
      padding: 30px 20px;
    }

    .card-dashboard:hover {
      transform: translateY(-10px) scale(1.03);
      box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    }

    .card-dashboard i {
      font-size: 50px;
      margin-bottom: 15px;
    }

    .card-dashboard h4 {
      font-weight: 600;
    }

    .logout-btn {
      position: fixed;
      top: 20px;
      right: 20px;
    }

    @media (max-width: 576px) {
      .card-dashboard i {
        font-size: 40px;
      }
    }
  </style>
</head>
<body>

<div class="container py-5">
  <div class="dashboard-header">
    <h1>👩‍💻 Admin Dashboard</h1>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['admin']); ?></p>
    <a href="logout.php" class="btn btn-outline-danger logout-btn">Logout</a>
  </div>

  <div class="row g-4">
    <!-- Workshops Card -->
    <div class="col-md-6 col-lg-3">
      <div class="card card-dashboard" onclick="location.href='manage_workshop.php'">
        <i class="bi bi-journal-bookmark-fill"></i>
        <h4>Workshops</h4>
        <p>workshops</p>
      </div>
    </div>

    <!-- Placements Card -->
    <div class="col-md-6 col-lg-3">
      <div class="card card-dashboard" onclick="location.href='manage_placement.php'">
        <i class="bi bi-briefcase-fill"></i>
        <h4>Placements</h4>
        <p>placements</p>
      </div>
    </div>

    <!-- Gallery Card -->
    <div class="col-md-6 col-lg-3">
      <div class="card card-dashboard" onclick="location.href='manage_gallery.php'">
        <i class="bi bi-image-fill"></i>
        <h4>Gallery</h4>
        <p>images</p>
      </div>
    </div>

    <!-- Announcements Card -->
    <div class="col-md-6 col-lg-3">
      <div class="card card-dashboard" onclick="location.href='manage_announcement.php'">
        <i class="bi bi-megaphone-fill"></i>
        <h4>Announcements</h4>
        <p>latest updates</p>
      </div>
    </div>

    <!-- Companies Card -->
    <div class="col-md-6 col-lg-3">
      <div class="card card-dashboard" onclick="location.href='manage_companies.php'">
        <i class="bi bi-buildings-fill"></i>
        <h4>Companies</h4>
        <p>Manage companies</p>
      </div>
    </div>

    <!-- Events Card -->
    <div class="col-md-6 col-lg-3">
      <div class="card card-dashboard" onclick="location.href='manage_events.php'">
        <i class="bi bi-buildings-fill"></i>
        <h4>Events</h4>
        <p>Manage companies</p>
      </div>
    </div>

    <!-- Go's Card -->
    <div class="col-md-6 col-lg-3">
      <div class="card card-dashboard" onclick="location.href='manage_go.php'">
        <i class="bi bi-megaphone-fill"></i>
        <h4>GO'S</h4>
        <p>Manage GO'S</p>
      </div>
    </div>


    <!-- Faculty Card -->
    <div class="col-md-6 col-lg-3">
      <div class="card card-dashboard" onclick="location.href='manage_faculty.php'">
        <i class="bi bi-megaphone-fill"></i>
        <h4>Faculty</h4>
        <p>Manage Faculty</p>
      </div>
    </div>

    
<div class="col-md-6 col-lg-3">
      <div class="card card-dashboard" onclick="location.href='upload_survey_data.php'">
      <i class="bi bi-database-fill"></i>
        <h4>Upload Survey Data</h4>
        <p>Upload Survey Data</p>
      </div>
    </div>
 

<div class="col-md-6 col-lg-3">
      <div class="card card-dashboard" onclick="location.href='upload_student_data.php'">
       <i class="bi bi-people-fill"></i>
        <h4>Students Registration</h4>
        <p>Students Registration</p>
      </div>
    </div>
  

<div class="col-md-6 col-lg-3">
      <div class="card card-dashboard" onclick="location.href='students_reporting.php'">
      <i class="bi bi-bar-chart-line-fill"></i>
        <h4>Students Reporting</h4>
        <p> Students Reporting</p>
      </div>
    </div>
  


<div class="col-md-6 col-lg-3">
      <div class="card card-dashboard" onclick="location.href='session_management.php'">
      <i class="bi bi-calendar2-week-fill"></i>
        <h4>Manage Session</h4>
        <p>Manage Session</p>
      </div>         
    </div>
 



<div class="col-md-6 col-lg-3">
      <div class="card card-dashboard" onclick="location.href='promote_students.php'">
      <i class="bi bi-arrow-up-circle-fill"></i>
        <h4>Promote Students</h4>
        <p> Promote Students</p>
      </div>
    </div>
  


  </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
