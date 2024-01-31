<?php

require_once(__DIR__."/../classes/Db.php");
require_once(__DIR__."/../classes/Auth.php");
require_once(__DIR__."/../classes/Video.php");
require_once(__DIR__."/../classes/Photo.php");



session_start();

$role = isset($_SESSION["role"]) ? $_SESSION["role"] : "guest";

$database = new Database();
$connection = $database->connectionDB();

$videos = Video::getAllVideos($connection, "id, video_name, video_link");
$photos = Photo::getAllPhotos($connection, "id", "img_name", "upload_date");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/header.css">
    <script src="https://kit.fontawesome.com/f3c1d6cf9d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../query/header-query.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/videos.css">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../query/general-query.css">
    <link rel="stylesheet" href="../css/lightbox.min.css" type="text/css" media="screen" />
    <script src="../js/lightbox-plus-jquery.min.js"></script>
    <script src="../js/lightbox.min.js"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-265623977-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-265623977-1');
</script>

    <title>Meditační zahrada SHIBUMI</title>
</head>
<body>
<?php require "../assets/admin-header.php";?>
    <main>
  

<h3 class="text">Zde se můžete naladit na poklidnou atmosféru zenové zahrady.</h3>
<section class="link-container">
    <p id="link1" onclick="displayPage('1')" class="link active">Fotky</p> 
    <p id="link2" onclick="displayPage('2')" class="link active">Videa</p> 
    
</section>
<br>
<div id="page1" class="page active">
  <div class="gallery">

        <section class="adder">
        <?php if($role === "admin"): ?>
            <a href="uploadphoto.php">Přidat obrázek</a>
        <?php endif; ?>
        </section>

        <section class="photos">
        
        <?php
$thumbnailsDirectory = 'thumbnails/';
$largeImagesDirectory = 'resized/'; // Složka s velkými obrázky

// Načtení obsahu složky thumbnails
$thumbnails = scandir($thumbnailsDirectory);

// Procházení všech položek a vytvoření odkazů na velké obrázky
    foreach ($thumbnails as $thumbnail) {
        if ($thumbnail != '.' && $thumbnail != '..') {
            $fullImagePath = $largeImagesDirectory . pathinfo($thumbnail, PATHINFO_FILENAME) . '.jpg'; // předpokládáme, že obrázky jsou uloženy ve formátu JPEG
            echo '<a href="' . $fullImagePath . '" data-lightbox="photos"><img src="' . $thumbnailsDirectory . $thumbnail . '" alt="Miniatura"></a>';
            if ($role === "admin") {
                echo '<a href="delete_photo.php?filename=' . $thumbnail . '">Smazat obrázek</a>';
            }
        }
    }
    


?>
</section>
</div>
</div>
    
<div id="page2" class="page">
    
   
        <section class="adder">
        <?php if($role === "admin"): ?>
            <a href="addvideo.php">Přidat video</a>
        <?php endif; ?>
        </section>

        <section class="videos">

        <?php if(empty($videos)):?>
            <p>Zatím nebyla přidána žádná videa</p>
            <?php else: ?>
                <div class="all-videos">
                    <?php foreach($videos as $one_video):?>
                        <div class="one-video">
                            <h2><?php echo htmlspecialchars($one_video["video_name"])?> </h2>
                            <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                            <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" src="<?= htmlspecialchars($one_video['video_link']) ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                            </div>
                    
            <?php if ($role === "admin"): ?>
    <a href="delvideo.php?id=<?= $one_video['id'] ?>">smazat video</a>
    <a href="editvideo.php?id=<?= $one_video['id'] ?>">upravit video</a>
<?php endif; ?>

<br>
<br>
                        </div>
                        <?php if($role === "admin"): ?> 
        <?php endif; ?>
                        <?php endforeach ?>
                </div>
                <?php endif?>
        </section>
 </main>

<?php require "../assets/footer.php";?>
</body>
<script src="../js/header.js"></script>
<script src="../js/script.js"></script>
<script src="../js/lightbox-plus-jquery.min.js"></script>
<script src="../js/galerry.js"></script>
<script>
    $(document).ready(function(){
        // Inicializace lightboxu
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true
        });
    });
</script>
</html>