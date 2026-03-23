<?php include '../db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>College Placements</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{background:#ffffff;font-family:'Segoe UI',sans-serif;color:#1e293b;}
.hero{text-align:center;padding:80px 20px;background:linear-gradient(135deg,#e0f2fe,#f8fafc);}
.hero h1{font-size:2.5rem;font-weight:800;color:#1e3a8a;}
.section-title{text-align:center;font-weight:800;font-size:2rem;margin-bottom:10px;}
.shine-line{width:120px;height:4px;margin:0 auto 40px;background:linear-gradient(90deg,transparent,#3b82f6,transparent);}
.drive-card{background:#ffffff;border-radius:20px;padding:25px;box-shadow:0 10px 30px rgba(0,0,0,.15);text-align:center;}
.drive-card img{max-width:130px;height:80px;object-fit:contain;margin:auto;}
.student-card{background:#fff;border-radius:18px;padding:20px;text-align:center;box-shadow:0 10px 25px rgba(0,0,0,.12);}
.student-card img{width:120px;height:120px;border-radius:50%;object-fit:cover;}
.company-name{font-weight:600;color:#2563eb;}
.logo-slider{overflow:hidden;}
.logo-track{display:flex;gap:60px;animation:scroll 25s linear infinite;}
.logo-track img{height:80px;width:140px;object-fit:contain;}
@keyframes scroll{from{transform:translateX(0);}to{transform:translateX(-50%);}}
</style>
</head>

<body>

<?php include '../header.php'; ?>

<!-- HERO -->
<section class="hero">
  <h1>College Placement Cell</h1>
</section>

<!-- PLACEMENT DRIVES -->
<section class="container my-5">
<h2 class="section-title">💼 Placement Drives</h2>
<div class="shine-line"></div>

<div class="row g-4">

<?php 
$q=$conn->query("SELECT p.*, c.logo AS company_logo 
                 FROM placements p
                 LEFT JOIN company_info c ON c.company_name = p.company
                 ORDER BY p.date ASC");

while($r=$q->fetch_assoc()){ 

$logo = (!empty($r['company_logo']) && file_exists("../images/company_logo/".$r['company_logo'])) 
        ? "../images/company_logo/".$r['company_logo'] 
        : "../images/company_logo/default.png";
?>

<div class="col-md-4">
  <div class="drive-card">
    <img src="<?php echo $logo; ?>">
    <h5><?php echo $r['company']; ?></h5>
    <p><?php echo $r['date']; ?></p>
    <div class="countdown" data-date="<?php echo $r['date']; ?>"></div>
  </div>
</div>

<?php } ?>

</div>
</section>

<!-- PLACED STUDENTS -->
<section class="container my-5">
<h2 class="section-title">🎓 Placed Students</h2>
<div class="shine-line"></div>

<div class="row g-4">

<?php 
$q=$conn->query("SELECT * FROM placement ORDER BY name ASC"); 
while($r=$q->fetch_assoc()){ 
?>

<div class="col-md-3">
  <div class="student-card">
    <img src="<?php echo $r['image_url']; ?>">
    <h6><?php echo $r['name']; ?></h6>
    <div class="company-name"><?php echo $r['company']; ?></div>
  </div>
</div>

<?php } ?>

</div>
</section>

<!-- OUR RECRUITERS -->
<section class="container my-5">
<h2 class="section-title">🏢 Our Recruiters</h2>
<div class="shine-line"></div>

<div class="logo-slider">
<div class="logo-track">

<?php 
$q=$conn->query("SELECT * FROM company_info"); 
while($r=$q->fetch_assoc()){
echo '<img src="../images/company_logo/'.$r['logo'].'">';
}

$q=$conn->query("SELECT * FROM company_info"); 
while($r=$q->fetch_assoc()){
echo '<img src="../images/company_logo/'.$r['logo'].'">';
}
?>

</div>
</div>
</section>

<?php include '../footer.php'; ?>

</body>
</html>