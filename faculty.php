<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Faculty - Govt. Girls Polytechnic Amethi</title>

<style>
body { 
    margin:0;
    font-family: Arial, sans-serif; 
    background: #f4f6f9; 
}

/* 🔥 header ke niche space (IMPORTANT) */
.top-space{
    height:80px;
}  

.header {
    text-align:center; 
    padding: 50px 20px;
    background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
    color: white;
}

.header h1 { 
    margin:0; 
    font-size: 38px; 
    letter-spacing:2px; 
}

.section-title{
    margin:50px auto 20px;
    max-width:1100px;
    font-size:24px;
    font-weight:bold;
    color:#203a43;
    background:#eef3f7;
    padding:12px 15px;
    border-left:8px solid #2c5364;
    border-radius:5px;
}

/* 🔥 FIX: 2 cards per row */
.faculty-container{ 
    max-width:1100px; 
    margin:0 auto 40px; 
    display:grid;
    grid-template-columns: repeat(2, 1fr); /* FIX */
    gap:20px;
}

/* 🔥 same card but thoda clean */
.card {
    background:white; 
    display:flex; 
    align-items:center;
    padding:18px; 
    border-radius:12px;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
    transition:0.25s ease; /* smooth */
}

/* 🔥 light hover (over nahi) */
.card:hover {
    transform: translateY(-4px);
    box-shadow:0 6px 18px rgba(0,0,0,0.12);
}

.card img {
    width:130px;  /* thoda reduce */
    height:130px;   
    border-radius:50%;
    border:5px solid #203a43;
    object-fit:cover;
    margin-right:20px;
}

.info h3 { 
    margin: 0 0 6px 0; 
    color:#203a43; 
    font-size:20px; 
}

.info p { 
    margin:4px 0; 
    font-size:14px; 
    color:#444; 
}

.info strong{
    color:#2c5364;
}

.footer {
    text-align:center; 
    padding:20px; 
    background:#1c1c1c;
    color:white; 
    margin-top:50px;
    font-size:14px;
}

/* mobile */
@media(max-width:768px){
    .faculty-container{
        grid-template-columns:1fr;
    }
    .card{ 
        flex-direction:column; 
        text-align:center; 
    }
    .card img{ 
        margin-right:0; 
        margin-bottom:15px; 
    }
}
</style>

</head>
<body>

<?php include "header.php"?>

<div class="top-space"></div>

<div class="header">
    <h1>GGPA Amethi - Faculty</h1>
</div>

<?php 

$departments = mysqli_query($conn,"SELECT DISTINCT department FROM faculty");

while($dept = mysqli_fetch_assoc($departments)){

$department = $dept['department'];

?>

<div class="section-title">
    <?php echo $department; ?>
</div>

<div class="faculty-container">

<?php

$faculty = mysqli_query($conn,"SELECT * FROM faculty WHERE department='$department'");

while($row = mysqli_fetch_assoc($faculty)){

?>

<div class="card">

<img src="images/faculty/<?php  echo $row['photo']; ?>">

<div class="info">
<h3><?php echo $row['name']; ?></h3>

<p><strong><?php echo $row['designation']; ?></strong></p>

<p>Qualification: <?php echo $row['qualification']; ?></p>

<?php if(!empty($row['email'])){ ?>
<p>Email: <?php echo $row['email']; ?></p>
<?php } ?>

</div>

</div>

<?php } ?>

</div>

<?php } ?>

<?php include "footer.php"?>

</body>
</html>