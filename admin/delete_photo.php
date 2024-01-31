<?php
require "../classes/Db.php";
require "../classes/Auth.php";
require "../classes/Photo.php";
require "../classes/Url.php";

session_start();

// Ověření zda je uživatel přihlášený
if (!Auth::isLoggedIn()) {
    die("Nepovolený přístup");
}

$db = new Database();
$connection = $db->connectionDB();

// Získání jména souboru z URL
$filename = isset($_GET["filename"]) ? $_GET["filename"] : null;

// Ověření, zda je jméno souboru zadáno
if ($filename !== null) {
    // Zavolání metody deletePhoto s jménem souboru
    $thumbnailsDirectory = 'thumbnails/';
    $resizedDirectory = 'resized/';
    
    $thumbnailPath = $thumbnailsDirectory . $filename;
    $resizedPath = $resizedDirectory . $filename;

    // Ověření, zda soubor existuje
    if (file_exists($thumbnailPath) && file_exists($resizedPath)) {
        // Smazat soubory
        unlink($thumbnailPath);
        unlink($resizedPath);

        // Smazat záznam z databáze
        Photo::deletePhotoDb($connection, $filename);
        
        Url::redirectUrl("/web/Shibumi23/admin/videos.php");
    } else {
        echo "Soubor neexistuje.";
    }
} else {
    echo "Neplatné jméno souboru.";
}
?>

