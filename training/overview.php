<!DOCTYPE html>
<?php
session_start();
?>                                                            

<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Workshop & Placement Management System | Government Girls Polytechnic Amethi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  


<!-- Card CSS -->
<style>
.placement-section {
  background: linear-gradient(135deg, #ffffff, #f0f6ff);
  padding: 70px 0;
  overflow: hidden;
  position: relative;
}

.placement-title {
  text-align: center;
  font-weight: 700;
  font-size: 32px;
  margin-bottom: 50px;
  color: #0d2c54;
  letter-spacing: 1px;
}

.placement-wrapper {
  display: flex;
  width: max-content;
  animation: scroll 30s linear infinite;
}

.placement-track {
  display: flex;
  gap: 70px;
  padding: 10px 0;
}

.placement-item {
  width: 180px;
  height: 110px;
  background: #ffffff;
  border-radius: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 10px 25px rgba(0,0,0,0.08);
  transition: 0.4s;
}

 .placement-item img {
  max-width: 130px;
  max-height: 70px;
  object-fit: contain;
  /* filter: grayscale(100%); */
  transition: 0.4s;
} 

/* Hover Effect */
  .placement-item:hover {
  transform: translateY(-8px);
  box-shadow: 0 15px 35px rgba(0,123,255,0.2);
} 

.placement-item:hover img {
  filter: grayscale(0%);
} 

/* Infinite Scroll Animation */
 @keyframes scroll {
  from { transform: translateX(0); }
  to { transform: translateX(-50%); }
} 

.count-card {
  transition: transform 0.3s, box-shadow 0.3s;
  cursor: pointer;
}
.count-card:hover {
  transform: translateY(-8px) scale(1.03);
  box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}
.count-card p {
  color: #333 !important;
}
@media(max-width: 767px){
  .count-card {
    min-height: 220px;
    padding: 3rem 1rem;
  }
}

.upcoming-badge{
  display:inline-block;margin-top:8px;
  background:#0a3d62;color:#fff;
  padding:4px 10px;border-radius:20px;font-size:12px;
}
.card-container:hover {
  transform: translateY(-5px);
  box-shadow: 0 0 20px rgba(13,110,253,0.7), 0 0 40px rgba(13,110,253,0.5);
}

/* SECTION TITLE */
.section-title {
  text-align: center;
  font-size: 28px;
  font-weight: 700;
  margin-bottom: 30px;
  position: relative;
}
.section-title::after {
  content: "";
  width: 80px;
  height: 3px;
  background: linear-gradient(to right, #0d6efd, #6ec1e4);
  display: block;
  margin: 8px auto 0 auto;
  border-radius: 2px;
}

/* ROW */
.row-g {
  display: flex;
  flex-wrap: wrap;
  margin-left: -15px;  /* negative margin to balance column padding */
  margin-right: -15px;
  gap: 15px; 
  padding: 0 100px;          /* gap between cards */
}

/* COLUMN CARD */
.col-card {
  flex: 1 1 calc(33.333% - 20px);
  padding-left: 15px;   /* side spacing inside each column */
  padding-right: 15px;
  display: flex;
  margin-bottom: 20px;   /* vertical spacing between rows */
}

/* CARD */
.card-container {
  flex: 1;
  display: flex;
  flex-direction: column;
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 4px 15px rgba(13,110,253,0.3);
  padding: 20px;
  transition: 0.3s;
  height: 420px;
}
 .card-container:hover {
  transform: translateY(-5px);
  box-shadow: 0 0 20px rgba(13,110,253,0.7), 0 0 40px rgba(13,110,253,0.5);
} 

/* TOP COLOR LINE */
.card-top-line {
  height: 5px;
  width: 100%;
  border-radius: 5px 5px 0 0;
  margin-bottom: 15px;
  background: linear-gradient(to right, #0d6efd, #6ec1e4);
}

/* LOGO */
.card-logo-container {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background: #e0f0ff;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0 auto 10px auto;
  border: 3px solid #0d6efd;
  box-shadow: 0 0 10px rgba(13,110,253,0.5);
  transition: 0.3s;
}
.card-logo-container:hover {
  box-shadow: 0 0 20px rgba(13,110,253,0.7);
}
.card-logo-container img {
  width: 80px;
  height: 80px;
  object-fit: contain;
  border-radius: 50%;
}

/* COMPANY & BRANCH */
.card-company, .card-title {
  font-weight: 700;
  font-size: 16px;
  text-align: center;
  margin-bottom: 5px;
}

/* INFO */
.card-info {
  font-size: 14px;
  color: #444;
  font-weight: 600;
  margin-top: auto;
}
.card-info p {
  margin: 3px 0;
}

/* COUNTDOWN */
.countdown {
  font-size: 14px;
  font-weight: 700;
  color: #0d6efd;
  text-align: center;
  margin: 5px 0 10px 0;
}

/* BUTTON */
.btn-main {
  background: #0d6efd;
  color: #fff;
  border-radius: 25px;
  padding: 6px 15px;
  font-size: 14px;
  text-decoration: none;
  margin-top: 10px;
  display: inline-block;
  transition: 0.3s;
}
.btn-main:hover {
  background: #084298;
}

@media(max-width: 991px){
  .col-card { flex: 1 1 calc(50% - 20px); }
}
@media(max-width: 576px){
  .col-card { flex: 1 1 100%; }
}
.gallery-card{
  background:#fff;
  border-radius:15px;
  overflow:hidden;
  box-shadow:0 8px 20px rgba(0,0,0,0.08);
  transition:0.3s;
}
.gallery-card img{
  width:100%;
  height:220px;
  object-fit:cover;
  transition:0.4s;
}
.gallery-card:hover img{
  transform:scale(1.07);
}

/* AOS animations */
[data-aos] { opacity:0; transition-property: transform, opacity; }


/* Animations */
 @keyframes float-left {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}

@keyframes float-right {
  0% { transform: translateX(0); }
  100% { transform: translateX(50%); }
} 

/* ===== Placement Card Improvements ===== */

/* Company Name */
.card-company{
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 4px;
}

/* Branch / Title */
.card-title{
    font-size: 16px;
    font-weight: 500;
    color: #555;
    margin-bottom: 8px;
}

/* Countdown */
.countdown{
    margin-bottom: 8px;
    font-weight: 600;
    font-size: 15px;
    color: #0d6efd;
}

/* Card Info Section */
.card-info{
    margin-top: 5px;
}

/* Date, Time, Venue */
.card-info p{
    font-size: 15px;
    font-weight: 500;
    margin-bottom: 6px;
}


</style>


</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<body>
  <!-- Navbar -->
 <?php
include '../header.php'?>

<?php
include '../db.php';
$today = date('Y-m-d');
?>


<!-- ANNOUNCEMENT SECTION -->
 <!-- HERO + ANNOUNCEMENT COMBINED -->
<header id="home" class="hero py-3 border-bottom" style="background:#ffffff;">
  <div class="container">
    <div class="row align-items-center">

      <!-- LEFT SIDE -->
      <div class="col-lg-7">

        <h1 class="fw-bold">Workshop & Placement Management System</h1>
        <p class="text-secondary mb-2">
          Branch-wise updates for <strong>MOM</strong>, <strong>CSE</strong>, and <strong>ELEX</strong>.
        </p>

        <a href="#workshops" class="btn btn-primary btn-sm mt-1">Explore Workshops</a>
        <a href="#placements" class="btn btn-outline-dark btn-sm mt-1">Upcoming Placements</a>

        <!-- ANNOUNCEMENT BAR -->
        <div class="bg-light px-3 py-2 mt-3 rounded border" style="font-size:14px;">

          <marquee behavior="scroll" direction="left" scrollamount="5" 
                   onmouseover="this.stop();" 
                   onmouseout="this.start();">
            <b>📢 </b>

            <?php
            $today = date('Y-m-d');

            $sql = "SELECT notice_heading, google_drive_link, publish_date 
                    FROM notices 
                    WHERE type IN ('Workshop','Placement')
                    AND expiry_date >= '$today'
                    ORDER BY publish_date DESC";

            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $text = htmlspecialchars($row['notice_heading']);
                    $isNew = (strtotime($row['publish_date']) >= strtotime('-3 days'));

                    echo "<span style='margin-right:25px;'>";

                    // Notice text
                    echo $text;

                    // Eye icon sirf agar link ho
                    if (!empty($row['google_drive_link'])) {
                        echo " <a href='".$row['google_drive_link']."' target='_blank' style='text-decoration:none;'>👁</a>";
                    }

                    // Blinking red dot for new notice
                    if ($isNew) {
                        echo " <span style='color:red; font-size:18px; animation: blink 1s infinite;'>●</span>";
                    }

                    echo "</span>";
                }
            } else {
                echo "No latest workshop or placement announcements.";
            }
            ?>
          </marquee>

        </div>

      </div>
  <!-- RIGHT SIDE IMAGE -->
      <div class="col-lg-5 text-center">
        <img src="https://images.unsplash.com/photo-1523580846011-d3a5bc25702b?q=80&w=1600&auto=format&fit=crop"
             class="img-fluid rounded shadow"
             style="max-height:420px;">
      </div>

    </div>
  </div>
</header>


  <?php
// include 'db.php'; // Database connection

// Get counts from DB
$res = $conn->query("SELECT COUNT(*) AS total_workshops FROM workshops");
$workshops = ($res->num_rows > 0) ? $res->fetch_assoc()['total_workshops'] : 0;

$res = $conn->query("SELECT COUNT(*) AS total_placements FROM placement");
$placements = ($res->num_rows > 0) ? $res->fetch_assoc()['total_placements'] : 0;

$res = $conn->query("SELECT COUNT(*) AS high_placed FROM placement WHERE package >=10");
$high = ($res->num_rows > 0) ? $res->fetch_assoc()['high_placed'] : 0;

$res = $conn->query("SELECT COUNT(*) AS total_drives FROM placements");
$drives = ($res->num_rows > 0) ? $res->fetch_assoc()['total_drives'] : 0;

// Combine into array & sort ascending
$counts_combined = [
    "workshops" => $workshops,
    "placements" => $placements + $high,
    "drives" => $drives
];
asort($counts_combined);
?>


<!-- Count Cards Section -->
<section class="container my-5">
  <div class="row justify-content-center g-4">
    <?php
    // Light professional gradients
    $gradients = [
      "linear-gradient(135deg, #a8dadc 0%, #f1faee 100%)",  // Workshops - soft blue
      "linear-gradient(135deg, #457b9d 0%, #a8dadc 100%)",  // Placements - teal
      "linear-gradient(135deg, #f4a261 0%, #ffe5b4 100%)",  // Placement Drives - light orange
      "linear-gradient(135deg, #e9c46a 0%, #fefae0 100%)"   // Training Domains - soft yellow
    ];

    $titles = [
      "workshops" => "Workshops",
      "placements" => "Students Placed",
      "drives" => "Placement Drives",
      "domains" => " Companies Hiring"
    ];

    $links = [
      "workshops" => "workshop.php",
      "placements" => "placement.php",
      "drives" => "placement.php",
      "domains" => "Companies Hiring"

    ];

    $i = 0;
    foreach($titles as $key=>$title){
        $color = $gradients[$i % count($gradients)];
        $val = ($key == 'domains') ? '15' : ($counts_combined[$key] ?? 0);
      echo '
        <div class="col-lg-3 col-md-6 col-sm-6">
          <a href="'.$links[$key].'" style="text-decoration:none;">
            <div class="count-card text-center shadow p-5 rounded-4" style="background: '.$color.'; color:#333; min-height:250px; display:flex; flex-direction:column; justify-content:center;">
              <h2 class="display-4 fw-bold count" data-target="'.$val.'">'.($val ? '0+' : '').'</h2>
              <p class="fw-semibold fs-5 mt-3">'.$title.'</p>
            </div>
          </a>
        </div>
        ';
        $i++;
    }
    ?>
  </div>
</section>

<!-- Counter Animation -->
<script>
document.addEventListener("DOMContentLoaded", function() {
  const counters = document.querySelectorAll(".count");
  counters.forEach(counter => {
    let target = +counter.getAttribute("data-target");
    if(!target) return; // skip cards without target like Training Domains
    let count = 0;
    let duration = 1000;
    let increment = Math.ceil(target / (duration / 16));

    function updateCounter() {
      count += increment;
      if(count < target){
        counter.innerText = count + "+";
        setTimeout(updateCounter, 16);
      } else {
        counter.innerText = target + "+";
      }
    }
    updateCounter();
  });
});
</script>


<!-- ====== WORKSHOPS FIRST ====== -->
<div class="container py-5">

<section class="workshop-section mb-5">
  <h2 class="section-heading text-center mb-3">
    Workshops
    <span style="display:block;width:60px;height:3px;background:#0d6efd;margin:5px auto 0;border-radius:2px;"></span>
  </h2>

  <div class="row g-4">
  <?php
  $workshops = [];

  // ✅ Upcoming (FIXED)
  $sqlUpcoming = "SELECT w.*, c.logo AS logo, 'upcoming' as type
                  FROM workshops w
                  LEFT JOIN company_info c ON w.company = c.company_name
                  WHERE w.date >= CURDATE()
                  ORDER BY w.date ASC LIMIT 3";

  $resultUpcoming = $conn->query($sqlUpcoming);
  while($row = $resultUpcoming->fetch_assoc()){
    $workshops[] = $row;
  }
                  
  // ✅ Past (same logic)
  $remaining = 3 - count($workshops);
  if($remaining > 0){
    $sqlPast = "SELECT w.*, c.logo AS logo, 'past' as type
                FROM workshops w
                LEFT JOIN company_info c ON w.company = c.company_name
                WHERE w.date < CURDATE()
                ORDER BY w.date DESC LIMIT $remaining";  

    $resultPast = $conn->query($sqlPast);
    while($row = $resultPast->fetch_assoc()){
      $workshops[] = $row;
    }
  }

  foreach($workshops as $row){

    // ✅ Logo logic (same as workshop.php)
    $logo = $row['logo'] ?: 'default.png';

    $filePath = __DIR__ . "/../images/company_logo/" . $logo;

    if(!file_exists($filePath)){
      $logo = "default.png";
    }

    $finalPath = "../images/company_logo/" . $logo;
  ?>
  
  <div class="col-md-4 d-flex">
    <div class="workshop-card w-100 p-3 shadow-lg rounded" style="background:#fff; position:relative; border-top:4px solid #0d6efd;">
      
      <!-- Logo -->
      <div class="logo-container mb-3" style="width:100px;height:100px;margin:0 auto;border-radius:50%;border:3px solid #0d6efd;background:#e0f0ff;display:flex;align-items:center;justify-content:center;">
        <img src="<?php echo $finalPath; ?>" 
             style="width:80px;height:80px;object-fit:contain;border-radius:50%;">
      </div>

      <!-- Company & Title -->
      <div class="company fw-bold text-center"><?php echo htmlspecialchars($row['company']); ?></div>
      <div class="title text-center"><?php echo htmlspecialchars($row['title']); ?></div>

      <!-- Upcoming badge -->
      <?php if($row['type']=='upcoming'){ ?>
        <span style="position:absolute;top:15px;right:15px;background:#0d6efd;color:#fff;padding:5px 10px;border-radius:20px;font-size:12px;">Upcoming</span>
        <div class="text-center fw-bold text-primary mt-2" data-date="<?php echo $row['date'].' '.$row['time']; ?>">Loading...</div>
      <?php } ?>

      <!-- Info -->
      <div class="info mt-3 fw-semibold">
        <p>📅 <?php echo date("d M Y", strtotime($row['date'])); ?></p>
        <p>⏰ <?php echo $row['time']; ?></p>
        <p>📍 <?php echo htmlspecialchars($row['venue']); ?></p>
      </div>

    </div>
  </div>

  <?php } ?>
  </div>

  <div class="text-center mt-4">
    <a href="workshop.php" class="btn btn-main px-4 py-2" style="border-radius:25px;background:#0d6efd;color:#fff;">View More →</a>
  </div>

</section>
</div>
  <!-- ====== PLACEMENT SECTION ====== -->

<!-- ====== PLACEMENT SECTION ====== -->

<h2 class="section-title">Placements</h2>
<div class="row-g">
<?php
$placements = [];

// ✅ FIXED: company_info use kiya
$sqlPlacement = "SELECT p.*, c.logo AS company_logo 
                 FROM placements p
                 LEFT JOIN company_info c ON p.company = c.company_name
                 ORDER BY p.date DESC LIMIT 3";

$resultPlacement = $conn->query($sqlPlacement);

if($resultPlacement){
    while($row = $resultPlacement->fetch_assoc()){
        $placements[] = $row;
    }
}

foreach($placements as $row){

    // ✅ Logo logic (same as workshops)
    $logo = $row['company_logo'] ?: 'default.png';

    $filePath = __DIR__ . "/../images/company_logo/" . $logo;

    if(!file_exists($filePath)){
        $logo = "default.png";
    }

    $finalPath = "../images/company_logo/" . $logo;
?>
<div class="col-card">
  <div class="card-container">
    <div class="card-top-line"></div>

    <div class="card-logo-container">
      <img src="<?php echo $finalPath; ?>" alt="Logo">
    </div>

    <div class="card-company"><?php echo htmlspecialchars($row['company']); ?></div>
    <div class="card-title"><?php echo htmlspecialchars($row['branch']); ?></div>

    <?php if(strtotime($row['date'].' '.$row['time']) > time()){ ?>
      <div class="countdown" data-date="<?php echo $row['date'].' '.$row['time']; ?>">Loading...</div>
    <?php } ?>

    <div class="card-info">
      <p>📅 <?php echo date("d M Y", strtotime($row['date'])); ?></p>
      <p>⏰ <?php echo $row['time']; ?></p>
      <p>📍 <?php echo htmlspecialchars($row['venue']); ?></p>
    </div>
  </div>
</div>
<?php } ?>
</div>

<div class="text-center mt-4">
  <a href="placement.php" class="btn-main">View More →</a>
</div>

<script>
document.querySelectorAll(".countdown").forEach(function(timer){
  var countDate = new Date(timer.getAttribute("data-date")).getTime();
  var x = setInterval(function(){
    var now = new Date().getTime();
    var distance = countDate - now;
    if(distance < 0){
      timer.innerHTML = "";
      clearInterval(x);
      return;
    }
    var days = Math.floor(distance / (1000*60*60*24));
    var hours = Math.floor((distance % (1000*60*60*24)) / (1000*60*60));
    var minutes = Math.floor((distance % (1000*60*60)) / (1000*60));
    var seconds = Math.floor((distance % (1000*60)) / 1000);
    timer.innerHTML = days+"d "+hours+"h "+minutes+"m "+seconds+"s";
  },1000);
});
</script>

<!-- FLOATING UNIQUE PLACEMENT LOGOS-->
 <div class="placement-section">

  <h2 class="placement-title">Our Recruiters</h2>

  <div class="placement-wrapper">

    <!-- FIRST TRACK -->
    <div class="placement-track">
      <?php
      $logos = [];

      // ✅ company_info se data
      $sql = "SELECT DISTINCT logo FROM company_info WHERE logo IS NOT NULL ORDER BY company_id ASC";
      $result = $conn->query($sql);

      if($result && $result->num_rows > 0){
          while($row = $result->fetch_assoc()){
              $logo = $row['logo'] ?: 'default.png';

              // ✅ file check
              $filePath = __DIR__ . "/../images/company_logo/" . $logo;
              if(!file_exists($filePath)){
                  $logo = "default.png";
              }

              $logos[] = $logo;

              echo '<div class="placement-item">';
              echo '<img src="../images/company_logo/'.$logo.'" alt="Company">';
              echo '</div>';
          }
      }
      ?>
    </div>

    <!-- SECOND TRACK (duplicate for smooth scroll) -->
    <div class="placement-track">
      <?php
      foreach($logos as $logo){
          echo '<div class="placement-item">';
          echo '<img src="images/company_logo/'.$logo.'" alt="Company">';
          echo '</div>';
      }
      ?>
    </div>

  </div>

</div>
<!-- ===== Full Width Footer ===== -->

<script>
  document.getElementById("yr").textContent = new Date().getFullYear();
</script>



  <!-- Auth Modal -->
  <div class="modal fade" id="authModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Login / Sign up</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <ul class="nav nav-tabs" id="authTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">Login</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="signup-tab" data-bs-toggle="tab" data-bs-target="#signup" type="button" role="tab">Sign up</button>
            </li>
          </ul>
          <div class="tab-content pt-3">
            <div class="tab-pane fade show active" id="login" role="tabpanel">
              <form onsubmit="event.preventDefault();alert('Logged in (demo).')">
                <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Password</label><input type="password" class="form-control" required></div>
                <button class="btn btn-brand text-white w-100">Login</button>
              </form>
            </div>
            <div class="tab-pane fade" id="signup" role="tabpanel">
              <form onsubmit="event.preventDefault();alert('Account created (demo).')">
                <div class="row g-3">
                  <div class="col-md-6"><label class="form-label">Full Name</label><input class="form-control" required></div>
                  <div class="col-md-6"><label class="form-label">Branch</label>
                    <select class="form-select">
                      <option value="MOM">MOM</option>
                      <option value="CSE">CSE</option>
                      <option value="ELEX">ELEX</option>
                    </select>
                  </div>
                  <div class="col-12"><label class="form-label">Email</label><input type="email" class="form-control" required></div>
                  <div class="col-12"><label class="form-label">Password</label><input type="password" class="form-control" required></div>
                  <div class="col-12"><button class="btn btn-brand text-white w-100">Create Account</button></div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include "../footer.php"?>
  <script>
function filterCards(){
    const sel = document.querySelector('input[name="branch"]:checked').value;
    const q = searchInput.value.trim().toLowerCase();

    document.querySelectorAll('[data-type]').forEach(card => {
        const type = card.getAttribute('data-type');
        let matchBranch = true;
        let matchQuery = true;

        if(type === 'workshop' || type === 'placement'){
            const branch = card.getAttribute('data-branch');
            const title = card.getAttribute('data-title').toLowerCase();
            const tags = (card.getAttribute('data-tags') || '').toLowerCase();
            matchBranch = sel === 'ALL' || branch === sel;
            matchQuery = !q || title.includes(q) || tags.includes(q);
        }
        else if(type === 'gallery'){
            const title = card.getAttribute('data-title').toLowerCase();
            matchQuery = !q || title.includes(q);
        }

        card.style.display = (matchBranch && matchQuery) ? '' : 'none';
    });
}
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>


</body>
</html>