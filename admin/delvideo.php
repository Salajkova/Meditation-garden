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

if($_SERVER["REQUEST_METHOD"] === "POST") {
    if (Video::delete_video($connection, $_GET["id"])) {
            Url::redirectUrl("/web/shibumi23/admin/videos.php");
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
    <title>Document</title>
</head>
<body>
<?php require "../assets/admin-header.php";?>

<main>
    <?php if($role === "admin"): ?>
        <section class="del-form">
          <form action="delvideo.php?id=<?= $_GET['id']?>" method="POST">
            <p>Opravdu si přejete video vymazat?</p>

            <div class="btns">
                <button type="submit">Smazat</button>
                <a href="videos.php">Zrušit</a>
            </div>
          </form>
        </section>
        <?php else: ?>
            <section class="no-delete-form">
                <h1>Obsah této stránky je k&nbsp;dispozici pouze administrátorům.</h1>
            </section>

        <?php endif; ?>

    </main>
    
</body>
</html>