<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Courses - Govt Girls Polytechnic Amethi</title>

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{font-family: Arial; background:#eef2f7;}

.hero{
  background:url('https://images.pexels.com/photos/1181675/pexels-photo-1181675.jpeg') center/cover;
  padding:90px 20px; position:relative;
}
.overlay{position:absolute; inset:0; background:rgba(0,0,0,0.6);}
.hero-content{position:relative;}

.main-heading{color:#0a3d62; font-weight:bold; margin-bottom:40px;}

.course-box{
  background:#fff; border-radius:15px; margin-bottom:30px;
  box-shadow:0 8px 20px rgba(0,0,0,0.15);
  overflow:hidden; transition:0.3s;
}
.course-box:hover{transform:translateY(-6px);}

.course-img{width:100%; height:250px; object-fit:cover;}

.course-content{padding:25px;}
.course-content h3{color:#0a3d62; font-weight:700;}

.badge{margin-right:10px; margin-bottom:10px;}
</style>

</head>

<body>

<?php include "header.php"; ?>

<!-- HERO -->
<section class="hero">
  <div class="overlay"></div>
  <div class="container text-center text-white hero-content">
    <h1>Diploma Courses</h1>
    <p>Complete course details including eligibility, seats and career scope</p>
  </div>
</section>

<!-- COURSES -->
<section class="container py-5">

<h2 class="main-heading text-center">Our Branches</h2>

<!-- CSE -->
<div class="course-box">
  <img src="https://images.pexels.com/photos/546819/pexels-photo-546819.jpeg" class="course-img">

  <div class="course-content">
    <h3>Computer Science & Engineering</h3>

    <span class="badge bg-success">Total Seats: 75</span>
    <span class="badge bg-info">Lateral Entry: 7</span>
    <span class="badge bg-primary">Duration: 3 Years</span>

    <h5 class="mt-3">Eligibility Criteria</h5>
    <ul>
      <li>10th pass with minimum 35% marks</li>
      <li>Mathematics & Science compulsory</li>
    </ul>

    <h5>Lateral Entry Eligibility</h5>
    <ul>
      <li>12th Science OR ITI</li>
      <li>Direct 2nd year entry</li>
    </ul>

    <h5>Course Highlights</h5>
    <ul>
      <li>Programming (C, Java, Python)</li>
      <li>DBMS, Web Development</li>
      <li>Software Engineering</li>
    </ul>

    <h5>Career</h5>
    <p>Software Developer, Web Developer, Data Analyst</p>
  </div>
</div>

<!-- ELECTRONICS -->
<div class="course-box">
  <img src="https://images.pexels.com/photos/163100/circuit-circuit-board-resistor-computer-163100.jpeg" class="course-img">

  <div class="course-content">
    <h3>Electronics Engineering</h3>

    <span class="badge bg-success">Total Seats: 75</span>
    <span class="badge bg-info">Lateral Entry: 7</span>
    <span class="badge bg-primary">Duration: 3 Years</span>

    <h5 class="mt-3">Eligibility</h5>
    <ul>
      <li>10th pass (35% minimum)</li>
      <li>Science & Maths compulsory</li>
    </ul>

    <h5>Lateral Entry</h5>
    <ul>
      <li>12th Science OR ITI</li>
      <li>Direct 2nd year</li>
    </ul>

    <h5>Course Highlights</h5>
    <ul>
      <li>Digital Electronics</li>
      <li>Microprocessors</li>
      <li>Communication Systems</li>
    </ul>

    <h5>Career</h5>
    <p>Electronics Engineer, Technician, IoT Developer</p>
  </div>
</div>

<!-- MOM -->
<div class="course-box">
  <img src="https://images.pexels.com/photos/3183150/pexels-photo-3183150.jpeg" class="course-img">

  <div class="course-content">
    <h3>Modern Office Management & Secretarial Practice</h3>

    <span class="badge bg-warning text-dark">Total Seats: 37</span>
    <span class="badge bg-primary">Duration: 2 Years</span>

    <h5 class="mt-3">Eligibility</h5>
    <ul>
      <li>12th pass (any stream)</li>
    </ul>

    <h5>Lateral Entry</h5>
    <p>Not Available</p>

    <h5>Course Highlights</h5>
    <ul>
      <li>Office Management</li>
      <li>MS Office & Typing</li>
      <li>Communication Skills</li>
    </ul>

    <h5>Career</h5>
    <p>Office Assistant, Clerk, Data Entry Operator</p>
  </div>
</div>

</section>

<?php include "footer.php"; ?>

</body>
</html>