<?php
include("db.php");

// ✅ QUERY ADD KARO
$sql = "SELECT * FROM events";   // apni table ka naam check kar lena
$result = mysqli_query($conn, $sql);

// Optional check
if(!$result){
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
<title>College Events</title>

<style>
                   
body{
font-family: Arial;
background:#f4f4f4;
}

.event-card{
display:flex;
align-items:center;
border:1px solid #ccc;
padding:15px;
margin:20px auto;
width:80%;
box-shadow:0 0 10px gray;
background:white;
}

.event-img{
width:40%;
}

.event-img img{
width:100%;
border-radius:6px;
}

.event-details{
width:60%;
padding-left:20px;
}

.event-details h3{
margin-top:0;
color:#333;
}

.event-details p{
margin:8px 0;
}

.event-details a{
display:inline-block;
padding:8px 15px;
background:#007bff;
color:white;
text-decoration:none;
border-radius:4px;
}

.event-details a:hover{
background:#0056b3;
}

</style>

</head>

<body>

<?php include "header.php"?>

<h1 style="text-align:center;">College Events</h1>

<?php
while($row = mysqli_fetch_assoc($result))
{
?>

<div class="event-card">

<div class="event-img">
<img src="images/gallery/events/<?php echo $row['image']; ?>">
</div>

<div class="event-details">

<h3><?php echo $row['event_name']; ?></h3>

<p><?php echo $row['description']; ?></p>

<p><b>Date:</b> <?php echo $row['event_date']; ?></p>

<a href="<?php echo $row['link']; ?>" target="_blank">View Report</a>       

</div>

</div>

<?php
}
?>
<?php include "footer.php"?>
</body>
</html>






