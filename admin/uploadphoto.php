<?php

require_once(__DIR__."/../classes/Db.php");
require_once(__DIR__."/../classes/Auth.php");
require_once(__DIR__."/../classes/Url.php");
require_once(__DIR__."/../classes/Photo.php");

session_start();

if (!Auth::isLoggedIn()) {
    die("Nepovolený přístup!");
}

$role = $_SESSION["role"];

$database = new Database();
$connection = $database->connectionDB();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"])) {
    // Instance třídy Photo pro manipulaci s fotkou
    $photoHandler = new Photo();

    // Zavolání metody uploadImage pro nahrání fotky
    $result = $photoHandler->uploadImage($connection, $_FILES["fileToUpload"]);

    if ($result === true) {
        Url::redirectUrl("/web/Shibumi23/admin/videos.php");
    } else {
        echo "Nahrávání fotky selhalo.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/uploadphoto.css">
    <link rel="stylesheet" href="../query/header-query.css">
    <link rel="stylesheet" href="../query/general-query.css">
    <title>Shibumi</title>
</head>
<body>

<?php require "../assets/admin-header.php"; ?>
<main>
<form action="" method="post" enctype="multipart/form-data">
    <h2> Zde můžete nahrávat obrázky do galerie</h2>
    <p>Vyberte fotku k nahrání:</p>
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Nahrát fotku" name="submit">
</form>
    </main>
</body>
<script src="../js/header.js"></script>
</html>
