<?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

include '../db.php';

// ✅ LOGGER ADD
$logger = require __DIR__ . '/../logger.php';
$logger->info("admin_notices.php accessed");

// Add Notice
if(isset($_POST['add_notice'])){

    $logger->info("Add notice attempt", [
        'admin' => $_SESSION['admin'],
        'heading' => $_POST['notice_heading']
    ]);

    $heading = $conn->real_escape_string($_POST['notice_heading']);
    $type = $conn->real_escape_string($_POST['type']);
    $publish_date = $_POST['publish_date'];
    $expiry_date = $_POST['expiry_date'];
    $link = !empty($_POST['google_drive_link']) ? $conn->real_escape_string($_POST['google_drive_link']) : NULL;

    $sql = "INSERT INTO notices (notice_heading, type, publish_date, expiry_date, google_drive_link) 
            VALUES ('$heading','$type','$publish_date','$expiry_date','$link')";

    if($conn->query($sql)){

        $logger->info("Notice added successfully", [
            'admin' => $_SESSION['admin'],
            'heading' => $heading
        ]);

        $success = "Notice added successfully!";
    } else {

        $logger->error("Notice insert failed", [
            'error' => $conn->error
        ]);

        $error = "Error: ".$conn->error;
    }
}

// Delete Notice
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);

    $logger->info("Delete notice attempt", [
        'admin' => $_SESSION['admin'],
        'notice_id' => $id
    ]);

    if($id > 0){
        $sql = "DELETE FROM notices WHERE id=$id";

        if($conn->query($sql)){

            $logger->info("Notice deleted successfully", [
                'admin' => $_SESSION['admin'],
                'notice_id' => $id
            ]);

            header("Location: admin_notices.php");
            exit();
        } else {

            $logger->error("Notice delete failed", [
                'error' => $conn->error
            ]);

            $error = "Delete failed: ".$conn->error;
        }
    }
}

// Fetch Notices
$result = $conn->query("SELECT * FROM notices ORDER BY publish_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Notices</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{background:#f5f6fa; font-family:Poppins,sans-serif;}
        .container{margin-top:40px;}
        .card{border-radius:12px; box-shadow:0 6px 15px rgba(0,0,0,0.1);}
        .card:hover{transform:translateY(-3px); transition:0.3s;}
        table tbody tr td{vertical-align:middle;}
        .btn-primary:hover{background:#6C5CE7;}
        .notice-title{font-weight:600; font-size:1.1rem;}
        a{ text-decoration:none; }
    </style>
</head>
<body>
<div class="container">

    <h2 class="mb-4 text-primary">📢 Manage Notices</h2>

    <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <!-- Add Notice Form -->
    <div class="card p-4 mb-4">
        <h5 class="mb-3">Add New Notice</h5>
        <form method="POST" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="notice_heading" class="form-control" placeholder="Notice Heading" required>
            </div>
            <div class="col-md-2">
                <select name="type" class="form-control">
                    <option value="General">General</option>
                    <option value="Workshop">Workshop</option>
                    <option value="Placement">Placement</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="publish_date" class="form-control" required>
            </div>
            <div class="col-md-2">
                <input type="date" name="expiry_date" class="form-control" required>
            </div>
            <div class="col-md-2">
                <input type="text" name="google_drive_link" class="form-control" placeholder="Google Drive Link">
            </div>
            <div class="col-12 mt-2">
                <button type="submit" name="add_notice" class="btn btn-primary">Add Notice</button>
            </div>
        </form>
    </div>

    <!-- Notices Table -->
    <div class="card p-4">
        <h5 class="mb-3">Existing Notices</h5>
        <div style="overflow-x:auto;">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Notice Heading</th>
                        <th>Type</th>
                        <th>Publish Date</th>
                        <th>Expiry Date</th>
                        <th>Google Drive Link</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()){ ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['notice_heading']); ?></td>
                                <td><?php echo $row['type']; ?></td>
                                <td><?php echo $row['publish_date']; ?></td>
                                <td><?php echo $row['expiry_date']; ?></td>
                                <td>
                                    <?php if(!empty($row['google_drive_link'])){ ?>
                                        <a href="<?php echo $row['google_drive_link']; ?>" target="_blank">Link</a>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="edit_notice.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                    <a href="admin_notices.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete this notice?')">Delete</a>
                                </td>
                            </tr>
                    <?php } 
                    } else { 
                        echo "<tr><td colspan='7' class='text-center'>No notices found</td></tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
</body>
</html>