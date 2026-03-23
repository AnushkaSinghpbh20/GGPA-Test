<?php 
include 'db.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Notices</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
<?php include "header.php"?>

<div class="container my-5">

    <h2 class="text-center text-primary fw-bold mb-4">All Notices</h2>

    <?php
    $sql = "SELECT notice_heading, type, publish_date, google_drive_link 
            FROM notices 
            WHERE expiry_date >= CURDATE()
            ORDER BY publish_date DESC";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            $heading = htmlspecialchars($row['notice_heading']);
            $type = htmlspecialchars($row['type']);
            $date = date("d M Y", strtotime($row['publish_date']));
            $link = $row['google_drive_link'];

            echo "<div class='card mb-3 shadow-sm'>";
            echo "<div class='card-body'>";
            echo "<h5 class='fw-bold'>$heading</h5>";

            echo "<p class='text-muted mb-2'>
                    $type | $date";

            if (!empty($link)) {
                echo " <a href='$link' target='_blank' class='ms-2 text-primary'>
                        <i class='bi bi-eye-fill'></i>
                       </a>";
            }

            echo "</p>";

            echo "</div>";
            echo "</div>";
        }

    } else {
        echo "<div class='alert alert-info text-center'>No notices available.</div>";
    }
    ?>

</div>

<?php include "footer.php"?>

</body>
</html>