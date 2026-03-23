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
$logger->info("manage_companies.php accessed");

// Add Company
if(isset($_POST['add'])){

    $logger->info("Add company attempt", [
        'admin' => $_SESSION['admin'],
        'company_name' => $_POST['name']
    ]);

    $name = trim($_POST['name']);
    $website = trim($_POST['website']);
    $location = trim($_POST['location']);
    $logo = '';

    // ✅ FIXED IMAGE UPLOAD (FULL SAFE)
    if(isset($_FILES['logo']) && $_FILES['logo']['error'] == 0){

        $logo = time().'_'.$_FILES['logo']['name'];

        // ✅ correct folder path
    // ✅ NEW (Correct Path)
$uploadDir = __DIR__ . '/../images/company_logo/';

        // ✅ create folder if not exists
        if(!is_dir($uploadDir)){
            mkdir($uploadDir, 0777, true);
        }

        $targetPath = $uploadDir . $logo;

        if(!move_uploaded_file($_FILES['logo']['tmp_name'], $targetPath)){
            die("❌ Image upload failed. Check folder path: images/company_logo/");
        }
    }

    if(!empty($name)){
        $sql = "INSERT INTO company_info (company_name, website, logo, location) 
                VALUES ('$name','$website','$logo','$location')";
        
        if($conn->query($sql)){

            $logger->info("Company added successfully", [
                'admin' => $_SESSION['admin'],
                'company_name' => $name
            ]);

            $success = "Company added successfully!";
        } else {

            $logger->error("Company insert failed", [
                'error' => $conn->error
            ]);

            $error = "Error: ".$conn->error;
        }
    }
}

// Delete Company
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);

    $logger->info("Delete company attempt", [
        'admin' => $_SESSION['admin'],
        'company_id' => $id
    ]);

    if($conn->query("DELETE FROM company_info WHERE company_id=$id")){

        $logger->info("Company deleted successfully", [
            'admin' => $_SESSION['admin'],
            'company_id' => $id
        ]);
    } else {

        $logger->error("Company delete failed", [
            'error' => $conn->error
        ]);
    }

    header("Location: manage_companies.php");
    exit();
}

// Fetch Companies
$result = $conn->query("
    SELECT company_name, website, logo, location, company_id 
    FROM company_info 
    ORDER BY company_name ASC
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Companies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body{background:#f4f6f9; font-family:'Poppins',sans-serif; margin:0; padding:0;}
        .main-content{margin-left:240px; padding:30px 20px; min-height:100vh;}
        .card{padding:20px; margin-bottom:30px;}
        img.logo-thumb{height:50px; width:50px; object-fit:contain;}
        .btn:hover{opacity:0.85; transition:0.3s;}
    </style>
</head>
<body>

<div class="main-content">
    <h2 class="mb-4">🏢 Manage Companies</h2>

    <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <!-- Add Company Form -->
    <div class="card">
        <h5>Add New Company</h5>
        <form method="POST" enctype="multipart/form-data">

            <div class="row g-3">
                <div class="col-md-4">
                    <input class="form-control" type="text" name="name" placeholder="Company Name" required>
                </div>

                <div class="col-md-4">
                    <input class="form-control" type="text" name="website" placeholder="Website Link">
                </div>

                <div class="col-md-4">
                    <input class="form-control" type="text" name="location" placeholder="Location">
                </div>
            </div>

            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <input class="form-control" type="file" name="logo" accept="image/*" required>
                </div>

                <div class="col-md-6">
                    <button class="btn btn-primary w-50" type="submit" name="add">Add</button>
                </div>
            </div>

        </form>
    </div>

    <!-- Existing Companies Table -->
    <div class="card">
        <h5 class="mt-3">Existing Companies</h5>
        <table class="table table-bordered align-middle mt-2">
            <thead>
                <tr>
                    <th>Company Name</th>
                    <th>Website</th>
                    <th>Logo</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()){ ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['company_name']); ?></td>

                    <td>
                        <?php if(!empty($row['website'])){ ?>
                            <a href="<?php echo $row['website']; ?>" target="_blank">Visit</a>
                        <?php } else { echo "N/A"; } ?>
                    </td>

                    <td>
                        <?php if(!empty($row['logo'])){ ?>
                            <img src="../images/company_logo/<?php echo $row['logo']; ?>" class="logo-thumb">
                        <?php } else { echo "No Logo"; } ?>
                    </td>

                    <td><?php echo !empty($row['location']) ? $row['location'] : 'N/A'; ?></td>

                    <td>
                        <a href="?delete=<?php echo $row['company_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this company?')">Delete</a>
                    </td>
                </tr>
                <?php } ?>

                <?php if($result->num_rows===0){ ?>
                    <tr><td colspan="5" class="text-center">No companies added yet.</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>