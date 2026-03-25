<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Government Girls Polytechnic Amethi</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

 <!-- FONT AWESOME -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
  margin:0;
  font-family: Arial, Helvetica, sans-serif;
  background:#f4f6f8;
}

/* TOP HEADER */ 
.top-header{
  background:#0a3d62;
  color:#fff;
  font-size:14px;
  padding:6px 0;
  text-align:center;
}
.text-primary i:hover {
  transform: scale(1.2);
  transition: 0.2s;
}


/* NAVBAR
 .navbar{
  background:#ffffff;
  padding:5px 0;
  box-shadow:0 4px 12px rgba(0,0,0,0.08);
}
.navbar-brand img{
  height:40px;
}
 .navbar-nav .nav-link{
  color:#0a3d62 !important;
  font-weight:600;
  margin:0 6px;
  padding:6px 12px;
  border-radius:20px;
  transition:0.3s;
} 
 .navbar-nav .nav-link:hover{
  background:#0a3d62;
  color:#fff !important;
}
.dropdown-menu{
  border:none;
  border-radius:12px;
  padding:10px 0;
  box-shadow:0 10px 25px rgba(0,0,0,0.15);
}
.dropdown-item{
  padding:8px 18px;
  font-size:14px;
}
.dropdown-item:hover{
  background:#0a3d62;
  color:#fff;
} */

/* SLIDER */
.carousel-item img{
  height:420px;
  object-fit:cover;
  border-radius:12px;
}

/* DESCRIPTION CARD */
.about-card{
  background:#fff;
  padding:30px;
  border-radius:16px;
  box-shadow:0 18px 50px rgba(0,0,0,0.35);
  margin-top:-30px;
}

/* NOTICE + SOCIAL CARD */
.notice-box, .social-card{
  background:#fff;
  border-radius:12px;
  overflow:hidden;
  border:1px solid #ccc;
}
.notice-title{
  background:#0a3d62;
  color:#fff;
  padding:10px;
  font-weight:bold;
}
.notice-marquee{
  overflow:hidden;
  position:relative;
}
.notice-content{
  position:absolute;
  width:100%;
  animation:scrollUp 18s linear infinite;
}
.notice-content p{
  margin:12px;
  padding-left:10px;
  border-left:4px solid #0a3d62;
  font-size:14px;
}
.notice-marquee:hover .notice-content{
  animation-play-state:paused;
}
@keyframes scrollUp{
  0%{top:100%;}
  100%{top:-120%;}
}

/* MAP */
.map-box{
  background:#fff;
  padding:10px;
  border-radius:12px;
  box-shadow:0 15px 40px rgba(0,0,0,0.3);
  margin-bottom:30px;
}
.map-box iframe{
  width:100%;
  height:300px;
  border:0;
  border-radius:10px;
}

/* BUTTONS */
.btn-instagram, .btn-facebook, .btn-outline-primary{
  font-weight:bold;
}
.btn-instagram{
  background:#E4405F;
  color:#fff;
}
.btn-instagram:hover{
  background:#c13584;
  color:#fff;
}
.btn-facebook{
  background:#1877F2;
  color:#fff;
}
.btn-facebook:hover{
  background:#0d6efd;
  color:#fff;
}
.btn-outline-primary{ 
   color:#0a3d62;
  border-color:#0a3d62;
}
.btn-outline-primary:hover{
  background:#0a3d62;
  color:#fff;
 }  

/* FOOTER
.main-footer{
  background:#0a3d62;
  color:#ccc;
  padding:40px 0 15px 0;
}
.main-footer h5{
  color:#fff;
  margin-bottom:15px;
}
.main-footer p, 
.main-footer a{
  font-size:14px;
  color:#ccc;
  text-decoration:none;
}
.main-footer a:hover{
  color:#fff;
  text-decoration:none;
  padding-left:5px;
  transition:0.3s;
}
.footer-bottom{
  background:#111;
  color:#ccc;
  padding:12px 0;
  text-align:center;
  font-size:14px;
} */

/* EXPLORE MORE ABOUT */
.explore-card {
  background: #ffffff;
  border-radius: 20px;
  padding: 35px 25px;
  transition: 0.4s ease;
  box-shadow: 0 8px 25px rgba(0,0,0,0.06);
  min-height: 260px;
}

.explore-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 35px rgba(0,0,0,0.12);
}

.icon-box {
  width: 75px;
  height: 75px;
  margin: auto;
  border-radius: 50%;
  background: linear-gradient(135deg,#1e3c72,#2a5298);
  display: flex;
  align-items: center;
  justify-content: center;
}

.icon-box i {
  color: #fff;
  font-size: 28px;
}
/* SECTION */
.explore-section {
  background: #f5f7fb;
}

/* TITLE DESIGN */
.section-title {
  font-size: 34px;
  font-weight: 700;
  text-align: center;
  margin-bottom: 50px;
  position: relative;
  color: #0d6efd;
}

.section-title::after {
  content: "";
  width: 80px;
  height: 4px;
  background: linear-gradient(90deg, #007bff, #00c6ff);
  display: block;
  margin: 12px auto 0;
  border-radius: 5px;
}

/* CARD */
.explore-card {
  background: #ffffff;
  border-radius: 20px;
  padding: 40px 25px;
  transition: 0.4s;
  box-shadow: 0 10px 25px rgba(0,0,0,0.08);
  height: 100%;
  position: relative;
  overflow: hidden;
}

/* TOP BORDER */
.explore-card::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  height: 5px;
  width: 100%;
  background: linear-gradient(90deg, #007bff, #00c6ff);
}


.icon-box {
  font-size: 32px;
  color: #fff;                /* white icon */
  background: #007bff;        /* permanent blue */
  width: 75px;
  height: 75px;
  margin: auto;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}
/* HOVER */
.explore-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 18px 40px rgba(0,0,0,0.12);
}


/* TEXT */
.explore-card h5 {
  margin-top: 18px;
  font-weight: 600;
}

.explore-card p {
  font-size: 14px;
  color: #666;
}

</style>
</head>

<body>

<?php include 'db.php'; 
      define('BASE_PATH',__DIR__);
?>

<div class="top-header">
Government Girls Polytechnic Amethi | AICTE Approved | BTEUP Lucknow
</div>

<!-- NAVBAR -->
<?php include 'header.php'?>

<!-- CAROUSEL -->
<div class="container my-4">
  <div id="slider" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="images/college1.jpeg" class="d-block w-100">
      </div>
      <div class="carousel-item">
        <img src="images/college2.jpeg" class="d-block w-100">
      </div>
       <div class="carousel-item">
        <img src="images/college1.jpeg" class="d-block w-100">
      </div>
    </div>
  </div>
</div>

<!-- ABOUT CARD -->
<div class="container my-4">
  <div class="about-card">
    <h4 class="text-primary fw-bold mb-3">About GGP Amethi</h4>
    <p>
      Government Girls Polytechnic Amethi is a premier institute for girls' technical education. 
      It offers diploma courses with modern labs, experienced faculty, and strong industry connections. 
      The institute emphasizes practical learning, innovation, and career development. 
      <br><br>
      Official Links: 
      <a href="#" style="color:#0a3d62;font-weight:bold;">Mandatory Disclosure</a> &nbsp;|&nbsp;
      <a href="#" style="color:#0a3d62;font-weight:bold;">Awards & Recognition</a> &nbsp;|&nbsp;
      <a href="#" style="color:#0a3d62;font-weight:bold;">Know More</a>
    </p>
  </div>
</div>

<!-- <div class="container my-4">
  <div class="row g-4"> -->

    <div class="container my-5">
  <div class="row g-4">  

 <!-- UPDATES -->
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        
        <!-- HEADER -->
        <div class="card-header bg-primary text-white fw-bold">
          <i class="bi bi-bell-fill"></i> Latest Updates
        </div>

        <!-- BODY -->
        <div class="card-body p-2" style="height:260px; overflow:hidden;">
          <marquee direction="up" scrollamount="3" 
                   onmouseover="this.stop();" 
                   onmouseout="this.start();">

            <?php
            $today = date('Y-m-d');

            $sql = "SELECT notice_heading, type, publish_date, google_drive_link 
                    FROM notices 
                    WHERE expiry_date >= '$today' 
                    ORDER BY publish_date DESC";

            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $heading = htmlspecialchars($row['notice_heading']);
                    $type = htmlspecialchars($row['type']);
                    $date = date("d M Y", strtotime($row['publish_date']));
                    $link = $row['google_drive_link'];

                    echo "<div class='mb-3 border-bottom pb-2 d-flex justify-content-between align-items-center'>";

                    // LEFT
                    echo "<div>
                            <div class='fw-semibold'>$heading</div>
                            <small class='text-muted'>$type | $date</small>
                          </div>";

                    // RIGHT (EYE ICON)
                    if (!empty($link)) {
                        echo "<a href='$link' target='_blank' class='text-primary'>
                                <i class='bi bi-eye fs-5'></i>
                              </a>";
                    }

                    echo "</div>";
                }
            } else {
                echo "<p class='text-center mt-3'>No notices available right now.</p>";
            }
            ?>

          </marquee>
        </div>

        <!-- FOOTER -->
        <div class="card-footer text-center">
          <a href="notices.php" class="btn btn-sm btn-primary w-100">
            View All Notices
          </a>
        </div>

      </div>
    </div>

 <!-- FACEBOOK -->
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        
        <div class="card-body p-0" style="height:300px;">
          <iframe 
            src="https://www.facebook.com/plugins/page.php?href=https://www.facebook.com/ggpamethi&tabs=timeline"
            width="100%" height="100%"
            style="border:none;">
          </iframe>
        </div>
      </div>
    </div>

<!-- INSTAGRAM -->
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        
        <div class="card-body p-0" style="height:300px;">
          <iframe 
            src="https://www.instagram.com/ggpamethi/embed"
            width="100%" height="100%"
            style="border:none;">
          </iframe>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- EXPLORE SECTION -->

<!-- SECTION -->
<div class="explore-section py-5">
  <div class="container">

    <h2 class="section-title">Explore More</h2>

    <!-- TOP ROW -->
    <div class="row g-4 mb-4">

      <!-- Placement -->
      <div class="col-md-3">
        <a href="training/placement.php" style="text-decoration:none;color:inherit;">
        <div class="explore-card text-center">
          <div class="icon-box"><i class="fas fa-briefcase"></i></div>
          <h5>Placement</h5>
          <p>Top recruiters and placement opportunities.</p>
        </div>
        </a>
      </div>

      <!-- Training -->
      <div class="col-md-3">
        <a href="training/trainingHomePage.php" style="text-decoration:none;color:inherit;">
        <div class="explore-card text-center">
          <div class="icon-box"><i class="fas fa-laptop-code"></i></div>
          <h5>Training</h5>
          <p>Skill development programs.</p>
        </div>
        </a>
      </div>

      <!-- Workshops -->
      <div class="col-md-3">
        <a href="training/workshop.php" style="text-decoration:none;color:inherit;">
        <div class="explore-card text-center">
          <div class="icon-box"><i class="fas fa-chalkboard"></i></div>
          <h5>Workshops</h5>
          <p>Classroom-based practical sessions.</p>
        </div>
        </a>
      </div>

      <!-- Faculty -->
      <div class="col-md-3">
        <a href="faculty.php" style="text-decoration:none;color:inherit;">
        <div class="explore-card text-center">
          <div class="icon-box"><i class="fas fa-users"></i></div>
          <h5>Faculty</h5>
          <p>Experienced teachers and mentors.</p>
        </div>
        </a>
      </div>

    </div>

    <!-- BOTTOM ROW -->
    <div class="row g-4 justify-content-center">

      <!-- Events -->
      <div class="col-md-3">
        <a href="events.php" style="text-decoration:none;color:inherit;">
        <div class="explore-card text-center">
          <div class="icon-box"><i class="fas fa-calendar-check"></i></div>
          <h5>Events</h5>
          <p>Fests, seminars and technical events.</p>
        </div>
        </a>
      </div>

      <!-- Gallery -->
      <div class="col-md-3">
        <a href="#" style="text-decoration:none;color:inherit;">
        <div class="explore-card text-center">
          <div class="icon-box"><i class="fas fa-images"></i></div>
          <h5>Gallery</h5>
          <p>Campus memories and activities.</p>
        </div>
        </a>
      </div>

      <!-- Courses -->
      <div class="col-md-3">
        <a href="courses.php" style="text-decoration:none;color:inherit;">
        <div class="explore-card text-center">
          <div class="icon-box"><i class="fas fa-book-open"></i></div>
          <h5>Courses</h5>
          <p>Diploma and technical programs offered.</p>
        </div>
        </a>
      </div>

      <!-- IMP GO (same as before) -->
      <div class="col-md-3">
        <a href="go.php" style="text-decoration:none;color:inherit;">
        <div class="explore-card text-center">
          <div class="icon-box"><i class="fas fa-file-alt"></i></div>
          <h5>IMP GO</h5>
          <p>Important documents and notices.</p>
        </div>
        </a>
      </div>

    </div>

  </div>
</div>
<!-- MAP -->
<div class="container my-4">
  <div class="map-box">
    <h6 class="text-center text-primary">College Location</h6>
    <iframe src="https://www.google.com/maps?q=Government+Girls+Polytechnic+Amethi&output=embed"></iframe>
  </div>
</div>

<!-- FOOTER -->
 <?php include "footer.php"?>

</body>
</html>
