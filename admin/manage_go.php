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
$logger->info("manage_go.php accessed");

// Add Government Order
if(isset($_POST['add'])){

    $logger->info("Add GO attempt", [
        'admin' => $_SESSION['admin'],
        'title' => $_POST['title']
    ]);

    $title = trim($_POST['title']);
    $file_path = '';

    if(isset($_FILES['file']) && $_FILES['file']['error'] == 0){
        $file_name = time().'_'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], 'images/'.$file_name);
        $file_path = 'images/'.$file_name;
    }

    if(!empty($title) && !empty($file_path)){
        $sql = "INSERT INTO government_orders (title, file_path) 
                VALUES ('$title','$file_path')";

        if($conn->query($sql)){

            $logger->info("Government Order added successfully", [
                'admin' => $_SESSION['admin'],
                'title' => $title
            ]);

            $success = "Government Order added successfully!";
        } else {

            $logger->error("GO insert failed", [
                'error' => $conn->error
            ]);

            $error = "Error: ".$conn->error;
        }
    } else {

        $logger->error("GO add failed - missing title or file");

        $error = "Title and File are required!";
    }
}

// Delete Government Order
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);

    $logger->info("Delete GO attempt", [
        'admin' => $_SESSION['admin'],
        'go_id' => $id
    ]);

    if($conn->query("DELETE FROM government_orders WHERE id=$id")){

        $logger->info("Government Order deleted successfully", [
            'admin' => $_SESSION['admin'],
            'go_id' => $id
        ]);

    } else {

        $logger->error("GO delete failed", [
            'error' => $conn->error
        ]);
    }

    header("Location: manage_go.php");
    exit();
}

// Fetch Government Orders
$result = $conn->query("SELECT id, title, file_path FROM government_orders ORDER BY id DESC");

// Random icons array for cards
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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Government Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body{background:#f4f6f9; font-family:'Poppins',sans-serif; margin:0; padding:0;}
        .main-content{margin-left:240px; padding:30px 20px; min-height:100vh;}
        .go-card{border-radius:10px; padding:30px; text-align:center; background:#ffffff; box-shadow:0 5px 15px rgba(0,0,0,0.1); transition:0.3s; height:100%;}
        .go-card:hover{transform:translateY(-5px); box-shadow:0 10px 25px rgba(0,0,0,0.2);}
        .go-icon{font-size:45px; margin-bottom:15px; color:#0d6efd;}
    </style>
</head>
<body>
<div class="main-content">
    <h2 class="mb-4">📄 Manage Government Orders</h2>

    <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <!-- Add GO Form -->
    <div class="card mb-4">
        <h5>Add New Government Order</h5>
        <form method="POST" enctype="multipart/form-data" class="row g-3 mt-2">
            <div class="col-md-6">
                <input class="form-control" type="text" name="title" placeholder="GO Title" required>
            </div>
            <div class="col-md-6">
                <input class="form-control" type="file" name="file" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit" name="add">Add Government Order</button>
            </div>
        </form>
    </div>

    <!-- Existing GO Cards -->
    <div class="row g-4">
        <?php 
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $icon = $icons[array_rand($icons)];
        ?>
        <div class="col-md-3">
            <a href="<?php echo $row['file_path']; ?>" target="_blank" style="text-decoration:none;color:black;">
                <div class="go-card">
                    <div class="go-icon">
                        <i class="fas <?php echo $icon; ?>"></i>
                    </div>
                    <h5 class="go-title"><?php echo $row['title']; ?></h5>
                    <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger mt-2" onclick="return confirm('Delete this order?')">Delete</a>
                </div>
            </a>
        </div>
        <?php } 
        } else { ?>
            <p class="text-center">No Government Orders added yet.</p>
        <?php } ?>
    </div>
</div>
</body>
</html>