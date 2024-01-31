<?php

require_once(__DIR__."/../classes/Db.php");
require_once(__DIR__."/../classes/Auth.php");
require_once(__DIR__."/../classes/Seminar.php");
require_once(__DIR__."/../classes/Url.php");

session_start();

if(!Auth::isLoggedIn()) {
    die("nepovolený přístup!");
}

$role = $_SESSION["role"];

$database = new Database();
$connection = $database->connectionDB();

if($_SERVER["REQUEST_METHOD"] === "POST") {
    if (Seminar::delete_seminar($connection, $_GET["id"])) {
            Url::redirectUrl("/web/shibumi23/admin/seminars.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/header.css">
    <script src="https://kit.fontawesome.com/f3c1d6cf9d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../query/header-query.css">
    <link rel="stylesheet" href="../query/general-query.css">
    <link rel="stylesheet" href="../css/delseminar.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/general.css">
    <title>Meditační zahrada SHIBUMI</title>
</head>
<body>
<?php require "../assets/admin-header.php";?>

<main>
    <?php if($role === "admin"): ?>
        <section class="del-form">
          <form action="delseminar.php?id=<?= $_GET['id']?>" method="POST">
            <p>Opravdu si přejete seminář vymazat?</p>

            <div class="btns">
                <button type="submit">Smazat</button>
                <a href="oneseminar.php?id=<?= $_GET['id'] ?>">Zrušit</a>
            </div>
          </form>
        </section>
        <?php else: ?>
            <section class="no-delete-form">
                <h1>Obsah této stránky je k&nbsp;dispozici pouze administrátorům.</h1>
            </section>

        <?php endif; ?>

    </main>
    <?php require "../assets/footer.php";?>
</body>
<script src="../js/header.js"></script>
</html>