<?php

require_once(__DIR__."/../classes/Db.php");
require_once(__DIR__."/../classes/Auth.php");
require_once(__DIR__."/../classes/Video.php");
require_once(__DIR__."/../classes/Url.php");

session_start();

if(!Auth::isLoggedIn()) {
    die("nepovolený přístup!");
}

$role = $_SESSION["role"];

$database = new Database();
$connection = $database->connectionDB();

if(isset($_GET["id"])) {
    $one_video = Video::get_video($connection, $_GET["id"]);

    if($one_video) {

        $video_name = $one_video["video_name"];
        $video_link = $one_video["video_link"];
        $id = $one_video["id"];
        
    } else {
        die("Video nenalezeno!");
    }
} else {
    die("id není zadáno!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $video_name = $_POST["video_name"];
    $video_link = $_POST["video_link"];


    if(Video::update_video($connection, $video_name, 
    $video_link, $id)) {
        Url::redirectUrl("/web/shibumi23/admin/videos.php");
    };
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../query/query-header.css">
    <link rel="stylesheet" href="../css/general.css">
    <title>Document</title>
</head>
<body>
<?php require "../assets/admin-header.php";?>

<main>
 <?php
 if($role === "admin") {
    require "../assets/form-video.php";
 } else {
    echo "<h1> Obsah stránky je k dispozici pouze administrátorům</h1>";
 }?>


</main>
</body>
</html>