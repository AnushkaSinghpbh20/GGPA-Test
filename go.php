<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Government Orders</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

/* 🔥 BODY FIX */
body{
background:#f4f7fb;
}

/* 🔥 HEADING FIX (MOST IMPORTANT) */
.main-heading{
text-align:center;
font-weight:700;
margin-top:100px; /* 👈 HEADER overlap fix */
margin-bottom:40px;
font-size:28px;
color:#222;
}

/* 🔥 CARD DESIGN */
.go-card{
border-radius:12px;
padding:30px 20px;
text-align:center;
background:#fff;
box-shadow:0 4px 12px rgba(0,0,0,0.08);
transition:0.3s;
height:100%;
}

.go-card:hover{
transform:translateY(-5px);
box-shadow:0 8px 20px rgba(0,0,0,0.15);
}

/* ICON */
.go-icon{
font-size:45px;
margin-bottom:15px;
color:#0d6efd;
}

/* TITLE */
.go-title{
font-size:16px;
font-weight:600;
margin-bottom:10px;
}

/* BUTTON */
.view-btn{
display:inline-block;
padding:5px 15px;
background:#0d6efd;
color:#fff;
border-radius:5px;
text-decoration:none;
font-size:14px;
}

.view-btn:hover{
background:#0b5ed7;
}

</style>

</head>

<body>

<?php include 'header.php'; ?>

<!-- ✅ HEADING (NOW FIXED) -->
<h2 class="main-heading">Important Government Orders</h2>

<div class="container pb-5">

<div class="row g-4">

<?php
$icons = [
    'fa-money-bill-wave',
    'fa-hand-holding-heart',
    'fa-file-alt',
    'fa-university',
    'fa-book',
    'fa-file-invoice',
    'fa-certificate',
    'fa-file-pdf'
];

$result = $conn->query("SELECT * FROM government_orders ORDER BY id DESC");

if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $icon = $icons[array_rand($icons)];
?>

<div class="col-md-3">          

<div class="go-card">

<div class="go-icon">
<i class="fas <?php echo $icon; ?>"></i>
</div>

<div class="go-title">
<?php echo $row['title']; ?>
</div>

<a href="<?php echo $row['file_path']; ?>" target="_blank" class="view-btn">
View
</a>

</div>

</div>

<?php
    }
}else{
    echo "<p class='text-center text-danger'>No Data Found</p>";
}
?>

</div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>