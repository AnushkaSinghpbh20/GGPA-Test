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
$logger->info("manage_gallery.php accessed");

// Folder list
$folders = [
    'workshop' => 'Workshop',
    'placement' => 'Placement',
    'seminars' => 'Seminars',
    'celebration' => 'Celebrations',
    'events' => 'Events'
];

// Selected folder
$selectedFolder = isset($_POST['folder']) ? $_POST['folder'] : 'workshop';
$uploadDir = "uploads/$selectedFolder/";
if(!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

// Upload image
if(isset($_POST['upload'])){

    $logger->info("Gallery upload attempt", [
        'admin' => $_SESSION['admin'],
        'folder' => $selectedFolder
    ]);

    if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){
        $filename = time().'_'.basename($_FILES['image']['name']);
        $targetPath = $uploadDir.$filename;

        if(move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)){
            $stmt = $conn->prepare("INSERT INTO gallery (folder_name, image_name, status) VALUES (?, ?, 'Active')");
            $stmt->bind_param("ss", $selectedFolder, $filename);
            $stmt->execute();
            $stmt->close();

            $logger->info("Gallery image uploaded successfully", [
                'admin' => $_SESSION['admin'],
                'folder' => $selectedFolder,
                'image' => $filename
            ]);

            $_SESSION['success'] = "Image uploaded successfully!";
        } else {

            $logger->error("Gallery upload failed (move_uploaded_file)");

            $_SESSION['error'] = "Failed to upload image!";
        }
    } else {

        $logger->error("Gallery upload failed (no file selected)");

        $_SESSION['error'] = "Please select an image!";
    }
    header("Location: manage_gallery.php");
    exit();
}

// Delete image (soft delete)
if(isset($_POST['delete_image_id'])){
    $id = intval($_POST['delete_image_id']);

    $logger->info("Gallery delete attempt", [
        'admin' => $_SESSION['admin'],
        'image_id' => $id
    ]);

    $stmt = $conn->prepare("UPDATE gallery SET status='Deleted' WHERE id=?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()){
        $logger->info("Gallery image marked deleted", [
            'admin' => $_SESSION['admin'],
            'image_id' => $id
        ]);
    } else {
        $logger->error("Gallery delete failed");
    }

    $stmt->close();
    echo "success";
    exit();
}

// Fetch images
$stmt = $conn->prepare("SELECT * FROM gallery WHERE folder_name=? ORDER BY upload_time DESC");
$stmt->bind_param("s", $selectedFolder);
$stmt->execute();
$result = $stmt->get_result();
$images = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Gallery</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
body {
    font-family: 'Poppins', sans-serif;
    background: #f4f6f9;
    margin: 0;
    padding: 0;
}
.container-box {
    margin-left: 250px;
    padding: 20px;
}
.card-form {
    border-radius: 15px;
    padding: 20px;
    background: #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.img-thumb {
    height: 120px;
    width: 150px;
    object-fit: cover;
    margin: 10px;
    border-radius: 10px;
    border: 1px solid #ccc;
}
.alert-ajax {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
}
.position-relative {
    position: relative;
}
</style>
</head>
<body>

<div class="container-box">
    <h2 class="mb-4">🖼 Manage Gallery</h2>

    <!-- Alerts -->
    <?php
    if(isset($_SESSION['success'])){ echo "<div class='alert alert-success alert-ajax'>{$_SESSION['success']}</div>"; unset($_SESSION['success']); }
    if(isset($_SESSION['error'])){ echo "<div class='alert alert-danger alert-ajax'>{$_SESSION['error']}</div>"; unset($_SESSION['error']); }
    ?>

    <!-- Folder Select -->
    <form method="POST" class="mb-3">
        <label>Select Folder:</label>
        <select name="folder" class="form-select w-25 d-inline" onchange="this.form.submit()">
            <?php foreach($folders as $key=>$val){ ?>
                <option value="<?= $key ?>" <?= $selectedFolder==$key?'selected':'' ?>><?= $val ?></option>
            <?php } ?>
        </select>
    </form>

    <!-- Upload Form -->
    <div class="card card-form mb-4">
        <form method="POST" enctype="multipart/form-data">
            <label>Upload Image:</label>
            <input type="file" name="image" class="form-control mb-2" required>
            <button class="btn btn-primary" type="submit" name="upload">Upload</button>
        </form>
    </div>

    <!-- Display Images -->
    <div class="card card-form p-3">
        <h5>Images in <?= ucfirst($selectedFolder) ?></h5>
        <div class="d-flex flex-wrap">
            <?php
            if(empty($images)){
                echo "<p>No images found.</p>";
            } else {
                foreach($images as $img){ ?>
                    <div class="position-relative text-center">
                        <img src="uploads/<?= $selectedFolder ?>/<?= $img['image_name'] ?>" class="img-thumb">
                        <p>Status: <?= $img['status'] ?></p>
                        <button class="btn btn-danger btn-sm deleteBtn" data-id="<?= $img['id'] ?>">Delete</button>
                    </div>
            <?php }} ?>
        </div>
    </div>
</div>

<script>
// Auto hide alerts
$(document).ready(function(){
    setTimeout(function(){
        $('.alert-ajax').fadeOut('slow');
    },2500);
});

// Delete image
$('.deleteBtn').click(function(){
    if(confirm('Mark this image as Deleted?')){
        let id = $(this).data('id');
        let parent = $(this).closest('div.position-relative');
        $.post('manage_gallery.php',{delete_image_id:id},function(res){
            if(res=='success'){
                parent.find('p').text('Status: Deleted');
            }
        });
    }
});
</script>

</body>
</html>
