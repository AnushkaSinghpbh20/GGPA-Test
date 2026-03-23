<?php
include '../db.php'; // DB connection

// Categories mapping
$categories = [
    'workshop' => 'Workshops',
    'placement' => 'Placements',
    'seminars' => 'Seminars',
    'celebration' => 'Celebrations',
    'events' => 'Events'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gallery</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/simplelightbox@2.14.1/dist/simple-lightbox.min.css" rel="stylesheet">

<style>
body { font-family: 'Montserrat', sans-serif; background:#f4f4f9; margin:0; padding:0; }
.gallery-header { text-align:center; padding:50px 20px 30px; color:#222; }
.gallery-header h1 { font-size:3rem; margin-bottom:10px; }
.gallery-header p { font-size:1.1rem; color:#555; }

.filter-buttons { text-align:center; margin-bottom:30px; }
.filter-buttons button { border:none; background:#6c63ff; color:#fff; padding:10px 20px; margin:5px; border-radius:50px; font-weight:600; transition:0.3s; cursor:pointer; }
.filter-buttons button:hover, .filter-buttons button.active { background:#ff6584; }

.category-section { padding: 20px 40px; }
.category-section h2 { margin-bottom:20px; text-align:center; color:#333; }

.gallery-container { column-count: 3; column-gap: 20px; }
@media (max-width:1200px){ .gallery-container{ column-count: 2; } }
@media (max-width:768px){ .gallery-container{ column-count: 1; } }

.gallery-item { break-inside: avoid; margin-bottom: 20px; position: relative; overflow: hidden; border-radius: 15px; transition: transform 0.3s, box-shadow 0.3s; cursor: pointer; }
.gallery-item img { width:100%; height:auto; display:block; border-radius:15px; transition: transform 0.5s; }
.gallery-item:hover img { transform: scale(1.05); }

.overlay { position:absolute; bottom:0; background:rgba(0,0,0,0.6); color:#fff; width:100%; height:0; transition:0.5s ease; display:flex; align-items:center; justify-content:center; text-align:center; padding:10px; border-radius:0 0 15px 15px;}
.gallery-item:hover .overlay { height:40%; }
.overlay h4 { margin:0; font-size:1.2rem; font-weight:600; }
</style>
</head>
<body>

<?php include '../header.php'; ?>

<div class="gallery-header">
    <h1>Our Gallery</h1>
    <p>Explore our workshops, placement drives, and campus events</p>
</div>

<!-- Filter Buttons -->
<div class="filter-buttons">
    <button class="active" onclick="filterSelection('all', event)">All</button>
    <?php foreach($categories as $key=>$val){ ?>
        <button onclick="filterSelection('<?= $key ?>', event)"><?= $val ?></button>
    <?php } ?>
</div>

<?php
foreach($categories as $key => $val){
    // Fetch images from DB (same query rakhi hai)
    $stmt = $conn->prepare("SELECT * FROM gallery WHERE folder_name = ? ORDER BY upload_time DESC");
    $stmt->bind_param("s", $key);
    $stmt->execute();
    $result = $stmt->get_result();

    $images = [];
    while($row = $result->fetch_assoc()){
        // ✅ SIRF YE LINE CHANGE KI HAI
        $images[] = [
            'path' => 'images/gallery/'.$row['image_name'],
            'title' => $val
        ];
    }
    $stmt->close();

    if(count($images) > 0){
        echo '<div class="category-section" data-category="'.$key.'">';
        echo '<h2>'.$val.'</h2>';
        echo '<div class="gallery-container">';
        foreach($images as $img){
            echo '<a href="'.$img['path'].'" class="gallery-item">';
            echo '<img src="'.$img['path'].'" alt="'.$img['title'].'">';
            echo '<div class="overlay"><h4>'.$img['title'].'</h4></div>';
            echo '</a>';
        }
        echo '</div></div>';
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/simplelightbox@2.14.1/dist/simple-lightbox.min.js"></script>
<script>
let lightbox = new SimpleLightbox('.gallery-container a', { captionsData: 'alt', captionDelay: 250 });

// Section-wise Filter
filterSelection("all");

function filterSelection(category, evt){
    let sections = document.querySelectorAll(".category-section");
    if(category === "all"){
        sections.forEach(s => s.style.display = "block");
    } else {
        sections.forEach(s => {
            if(s.getAttribute("data-category") === category){
                s.style.display = "block";
            } else {
                s.style.display = "none";
            }
        });
    }

    if(evt){
        let btns = document.querySelectorAll(".filter-buttons button");
        btns.forEach(btn => btn.classList.remove("active"));
        evt.target.classList.add("active");
    }
}
</script>

<?php include "../footer.php"?>
</body>
</html>
             












