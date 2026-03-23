<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

include '../db.php';
include 'sidebar.php';

// ✅ LOGGER ADD
$logger = require __DIR__ . '/../logger.php';
$logger->info("manage_events.php accessed");

// Add Event
if(isset($_POST['add'])){

    $logger->info("Add event attempt", [
        'admin' => $_SESSION['admin'],
        'event_name' => $_POST['event_name']
    ]);

    $event_name = trim($_POST['event_name']);
    $description = trim($_POST['description']);
    $event_date = $_POST['event_date'];
    $link = trim($_POST['link']);

    $image='';

    if(isset($_FILES['image']) && $_FILES['image']['error']==0){
        $image=time().'_'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'],'images/gallery/events/'.$image);
    }

    $sql="INSERT INTO events (event_name,description,event_date,link,image)
          VALUES ('$event_name','$description','$event_date','$link','$image')";

    if($conn->query($sql)){

        $logger->info("Event added successfully", [
            'admin' => $_SESSION['admin'],
            'event_name' => $event_name
        ]);

        $success="Event added successfully!";
    }else{

        $logger->error("Event insert failed", [
            'error' => $conn->error
        ]);

        $error="Error: ".$conn->error;
    }
}

// Delete Event
if(isset($_GET['delete'])){
    $id=intval($_GET['delete']);

    $logger->info("Delete event attempt", [
        'admin' => $_SESSION['admin'],
        'event_id' => $id
    ]);

    if($conn->query("DELETE FROM events WHERE event_id=$id")){

        $logger->info("Event deleted successfully", [
            'admin' => $_SESSION['admin'],
            'event_id' => $id
        ]);

    } else {

        $logger->error("Event delete failed", [
            'error' => $conn->error
        ]);
    }

    header("Location: manage_events.php");
    exit();
}

// Fetch Events
$result=$conn->query("SELECT * FROM events ORDER BY event_id DESC");

?>
<!DOCTYPE html>
<html>
<head>

<title>Manage Events</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:#f4f6f9;
font-family:'Poppins',sans-serif;
}

.main-content{
margin-left:240px;
padding:30px 20px;
min-height:100vh;
}

.card{
padding:20px;
margin-bottom:30px;
}

img.event-thumb{
height:50px;
width:60px;
object-fit:cover;
border-radius:6px;
}

</style>

</head>

<body>

<div class="main-content">

<h2 class="mb-4">🎉 Manage Events</h2>

<?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
<?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

<!-- Add Event -->

<div class="card">

<h5>Add New Event</h5>

<form method="POST" enctype="multipart/form-data" class="row g-3">

<div class="col-md-4">
<input class="form-control" type="text" name="event_name" placeholder="Event Name" required>
</div>

<div class="col-md-4">
<input class="form-control" type="date" name="event_date" required>
</div>

<div class="col-md-4">
<input class="form-control" type="text" name="link" placeholder="Report Link">
</div>

<div class="col-md-6">
<textarea class="form-control" name="description" placeholder="Event Description"></textarea>
</div>

<div class="col-md-4">
<input class="form-control" type="file" name="image" accept="image/*">
</div>

<div class="col-md-2">
<button class="btn btn-primary w-100" type="submit" name="add">Add</button>
</div>

</form>

</div>

<!-- Event Table -->

<div class="card">

<h5>Event List</h5>

<table class="table table-bordered align-middle mt-2">

<thead>
<tr>
<th>Image</th>
<th>Event Name</th>
<th>Date</th>
<th>Link</th>
<th>Actions</th>
</tr>
</thead>

<tbody>

<?php while($row=$result->fetch_assoc()){ ?>

<tr>

<td>
<?php if(!empty($row['image'])){ ?>
<img src="../images/<?php echo $row['image']; ?>" class="event-thumb">   
<?php } else { echo "No Image"; } ?>
</td>

<td><?php echo htmlspecialchars($row['event_name']); ?></td>

<td><?php echo $row['event_date']; ?></td>

<td>
<a href="<?php echo $row['link']; ?>" target="_blank">View</a>
</td>

<td>
<a href="?delete=<?php echo $row['event_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this event?')">Delete</a>
</td>

</tr>

<?php } ?>

<?php if($result->num_rows==0){ ?>

<tr>
<td colspan="5" class="text-center">No events added yet.</td>
</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</body>
</html>