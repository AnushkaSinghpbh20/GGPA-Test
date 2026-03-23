<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}
?>




<!-- Sidebar CSS -->
<style>
body {
    font-family: 'Poppins', sans-serif;
}
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    height: 100%;
    background: linear-gradient(135deg, #1abc9c, #3498db);
    color: #fff;
    box-shadow: 4px 0 15px rgba(0,0,0,0.2);
    z-index: 1000;
    transition: width 0.3s;
    overflow: hidden;
}
.sidebar-header {
    text-align: center;
    padding: 25px 0;
    background: rgba(0,0,0,0.2);
}
.sidebar-header h2 {
    font-size: 22px;
    font-weight: 700;
    margin: 0;
    color: #fff;
}
.sidebar-menu {
    display: flex;
    flex-direction: column;
    padding: 15px 0;
}
.sidebar-menu a {
    display: flex;
    align-items: center;
    padding: 12px 20px;
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    margin: 5px 10px;
    border-radius: 10px;
    transition: all 0.3s ease;
}
.sidebar-menu a i {
    margin-right: 15px;
    font-size: 18px;
    transition: transform 0.3s;
}
.sidebar-menu a:hover {
    background: rgba(255,255,255,0.15);
    transform: translateX(5px);
}
.sidebar-menu a:hover i {
    transform: rotate(15deg);
}
.sidebar-menu a.logout {
    margin-top: auto;
    background: #e74c3c;
}
.sidebar-menu a.logout:hover {
    background: #c0392b;
}
@media(max-width:768px){
    .sidebar {
        width: 70px;
    }
    .sidebar-menu a span {
        display: none;
    }
}
</style>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<!-- Modern Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <h2>Admin Panel</h2>
    </div>
    <nav class="sidebar-menu">
        <a href="dashboard.php"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a>
        <a href="manage_workshop.php"><i class="bi bi-journal-bookmark-fill"></i> <span>Workshops</span></a>
        <a href="manage_companies.php"><i class="bi bi-buildings-fill"></i> <span>Companies</span></a>
        <a href="manage_placement.php"><i class="bi bi-briefcase-fill"></i> <span>Placements</span></a>
        <a href="manage_events.php"><i class="bi bi-briefcase-fill"></i> <span>Events</span></a>
         <a href="manage_faculty.php"><i class="bi bi-buildings-fill"></i> <span>Faculty</span></a>

        <a href="manage_gallery.php"><i class="bi bi-image-fill"></i> <span>Gallery</span></a>
        <a href="manage_announcement.php"><i class="bi bi-megaphone-fill"></i> <span>Announcements</span></a>
                <a href="upload_survey_data.php">  <i class="bi bi-database-fill"></i> <span>Upload Survey Data</span></a>
        <a href="upload_student_data.php"><i class="bi bi-people-fill"></i> <span>Students Registration</span></a>
        <a href="session_management.php">    <i class="bi bi-calendar2-week-fill"></i><span>Manage Session</span></a>
                <a href="students_reporting.php"><i class="bi bi-megaphone-fill"></i> <span>Students Reporting</span></a>

                <a href="promote_students.php"> <i class="bi bi-arrow-up-circle-fill"></i> <span>Promote Students</span></a>
        <a href="logout.php" class="logout"><i class="bi bi-box-arrow-right"></i> <span>Logout</span></a>
    </nav>
</div>



      







