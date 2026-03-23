<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">



    <style>
body{
    margin:0;
    padding:0;
    font-family: Arial, sans-serif;
}

.navbar{
    background:#ffffff;
    padding:8px 0;
    box-shadow:0 4px 12px rgba(0,0,0,0.08);
}

.navbar-brand img{
    height:45px;
    border-radius:50%;
}

.nav-link{
    font-weight:500;
    color:#0a3d62 !important;
}

.nav-link:hover{
    color:#1e90ff !important;
}
                                        
.dropdown-menu{
    border-radius:10px;
}
</style>
</head>
<body>
    

<!-- ===== NAVBAR HTML ===== -->
<nav class="navbar navbar-expand-lg fixed-top">
<div class="container">

<a class="navbar-brand d-flex align-items-center" href="">
  <img src="/TPO_Project/images/GGPAmethi_Logo.jpeg">
  <span style="margin-left:8px;font-weight:bold;color:#0a3d62;">GGP Amethi</span>
</a>

<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
  ☰
</button>
               
<div class="collapse navbar-collapse" id="menu">
<ul class="navbar-nav ms-auto">

<li class="nav-item">
<a class="nav-link" href="/TPO_PROJECT/index.php">Home</a>
</li>

<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
About Us
</a>
<ul class="dropdown-menu">
<li><a class="dropdown-item" href="#">History</a></li>   
<li><a class="dropdown-item" href="#">Awards</a></li>   
<li><a class="dropdown-item" href="#">Campus Map</a></li>    
<li><a class="dropdown-item" href="#">Contact Us</a></li>              
<li><a class="dropdown-item" href="#">Mandatory Disclosure</a></li>        
</ul>                        
</li>                                                                    

<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
Academic
</a>
<ul class="dropdown-menu">
<li><a class="dropdown-item" href="/TPO_PROJECT/courses.php">Courses</a></li>
<li><a class="dropdown-item" href="#">Admission</a></li>
<li><a class="dropdown-item" href="#">Previous Year Papers</a></li>
<li><a class="dropdown-item" href="\project\uploads\UpdatedFeeStructure.08">Fee Structure</a></li>
<li><a class="dropdown-item" href="/TPO_PROJECT/faculty.php">Faculty</a></li>
</ul>
</li>

<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
Training & Placement
</a>
<ul class="dropdown-menu">
<li><a class="dropdown-item" href="/TPO_PROJECT/training/overview.php">Overview</a></li>   
<li><a class="dropdown-item" href="/TPO_PROJECT/training/workshop.php">Workshops</a></li>
<li><a class="dropdown-item" href="/TPO_PROJECT/training/placement.php">Placement</a></li>
<li><a class="dropdown-item" href="#">Alumni</a></li>
<li><a class="dropdown-item" href="/TPO_PROJECT/training/trainingHomePage.php">Industrial Training</a></li>
<li><a class="dropdown-item" href="#">E Learning</a></li>
</ul>
</li>

<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
Grievance
</a>
<ul class="dropdown-menu">
<li><a class="dropdown-item" href="#">Grievance Portal</a></li>
<li><a class="dropdown-item" href="#">Anti Ragging Complaints</a></li>
<li><a class="dropdown-item" href="#">AICTE Feedback</a></li>
</ul>
</li>


<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
Login
</a>
<ul class="dropdown-menu">
<li><a class="dropdown-item" href="/TPO_PROJECT/training/student_login.php">Students Login</a></li>
<li><a class="dropdown-item" href="/TPO_PROJECT/admin/admin_login.php">Admin Login</a></li>

</ul>
</li>

</ul>
<!-- </div>
</div> -->
</nav>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
