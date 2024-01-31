<?php

require_once(__DIR__."/../classes/Db.php");
require_once(__DIR__."/../classes/Auth.php");
require_once(__DIR__."/../classes/Video.php");
require_once(__DIR__."/../classes/Url.php");

session_start();

if(!Auth::isLoggedIn()) {
    die("nepovolený přístup!");
}

$role=$_SESSION["role"];

$database = new Database();
$connection = $database->connectionDB();

$video_name = null;
$video_link = null;


if ($_SERVER["REQUEST_METHOD"] === "POST") {
 var_dump($_POST);

    $video_name = $_POST["video_name"];
    $video_link = $_POST["video_link"];
    $id = Video::create_video($connection, $video_name, $video_link);

    if($id) {
        Url::redirectUrl("/web/shibumi23/admin/videos.php");
    } else {
        echo "Video nebylo vytvořeno!";
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../query/header-query.css">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../query/general-query.css">
    
    <title>Document</title>
</head>
<body>
    <?php require "../assets/admin-header.php";?>

    <main>
        <section class="add-form">
            <?php require "../assets/form-video.php";?>
        </section>
    </main>
    
</body>
</html>
