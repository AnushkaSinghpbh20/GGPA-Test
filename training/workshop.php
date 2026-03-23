<?php 
include '../db.php'; 
$today = date('Y-m-d');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Workshops</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.page-section{ padding:60px 0; }
.section-heading{text-align:center;font-weight:700;margin:40px 0 30px;color:#0a3d62;}
.workshop-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:30px;}

@media(max-width:992px){.workshop-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:576px){.workshop-grid{grid-template-columns:1fr;}}

.workshop-card{
background:#fff;
padding:25px;
border-radius:15px;
box-shadow:0 10px 30px rgba(0,0,0,0.15);
position:relative;
}

.logo-box{text-align:center;margin-bottom:15px;}

.company-logo{
max-width:120px;
max-height:60px;
object-fit:contain;
}

.company-name{text-align:center;font-weight:600;margin-bottom:10px;}
.workshop-info{font-size:14px;color:#555;text-align:center;}

.upcoming-badge{
position:absolute;
top:10px;
right:10px;
background:#ff4d4f;
color:#fff;
padding:4px 8px;
border-radius:5px;
font-size:12px;
}
</style>
</head>

<body>

<?php include "../header.php"; ?>

<div class="container page-section">

<!-- ================= UPCOMING ================= -->
<h3 class="section-heading">Upcoming Workshops</h3>

<div class="workshop-grid">

<?php
$q = $conn->query("SELECT * FROM workshops WHERE date >= '$today' ORDER BY date ASC");

while($row = $q->fetch_assoc()){

    $logo = "default.png";
    $company = $row['company'];

    $logoQuery = $conn->query("SELECT logo FROM company_info WHERE company_name='$company' LIMIT 1");

    if($logoQuery && $logoQuery->num_rows > 0){
        $logoRow = $logoQuery->fetch_assoc();
        if(!empty($logoRow['logo'])){
            $logo = $logoRow['logo'];
        }
    }

    // ✅ CORRECT SERVER PATH
    $filePath = __DIR__ . "/../images/company_logo/" . $logo;

    if(!file_exists($filePath)){
        $logo = "default.png";
    }

    // ✅ CORRECT BROWSER PATH
    $finalPath = "../images/company_logo/" . $logo;
?>

<div class="workshop-card">
    <div class="upcoming-badge">Upcoming</div>

    <div class="logo-box">
        <img src="<?php echo $finalPath; ?>" class="company-logo">
    </div>

    <h5 class="text-center"><?php echo $row['title']; ?></h5>

    <div class="company-name">
        <?php echo $row['company']; ?>
    </div>

    <div class="workshop-info">
        📅 <?php echo $row['date']; ?><br>
        ⏰ <?php echo $row['time']; ?><br>
        📍 <?php echo $row['venue']; ?>
    </div>
</div>

<?php } ?>

</div>


<!-- ================= PREVIOUS ================= -->
<h3 class="section-heading">Previous Workshops</h3>

<div class="workshop-grid">

<?php
$q = $conn->query("SELECT * FROM workshops WHERE date < '$today' ORDER BY date DESC");

while($row = $q->fetch_assoc()){

    $logo = "default.png";
    $company = $row['company'];

    $logoQuery = $conn->query("SELECT logo FROM company_info WHERE company_name='$company' LIMIT 1");

    if($logoQuery && $logoQuery->num_rows > 0){
        $logoRow = $logoQuery->fetch_assoc();
        if(!empty($logoRow['logo'])){
            $logo = $logoRow['logo'];
        }
    }

    // ✅ SAME FIX
    $filePath = __DIR__ . "/../images/company_logo/" . $logo;

    if(!file_exists($filePath)){
        $logo = "default.png";
    }

    $finalPath = "../images/company_logo/" . $logo;
?>

<div class="workshop-card">

    <div class="logo-box">
        <img src="<?php echo $finalPath; ?>" class="company-logo">
    </div>

    <h5 class="text-center"><?php echo $row['title']; ?></h5>

    <div class="company-name">
        <?php echo $row['company']; ?>
    </div>

    <div class="workshop-info">
        📅 <?php echo $row['date']; ?><br>
        📍 <?php echo $row['venue']; ?>
    </div>

</div>

<?php } ?>

</div>

</div>

<?php include "../footer.php"; ?>

</body>
</html>