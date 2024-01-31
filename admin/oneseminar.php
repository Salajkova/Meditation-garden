<?php

require_once(__DIR__."/../classes/Db.php");
require_once(__DIR__."/../classes/Auth.php");
require_once(__DIR__."/../classes/Seminar.php");


session_start();

$role = isset($_SESSION["role"]) ? $_SESSION["role"] : "guest";

$database = new Database();
$connection = $database->connectionDB();

if(isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $seminars = Seminar::get_seminar($connection, $_GET["id"]);
} else {
    $seminars = null;
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
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/oneseminar.css">
    <link rel="stylesheet" href="../css/general.css">
    <title>Meditační zahrada SHIBUMI</title>
</head>
<body>
    <?php require "../assets/admin-header.php";?>
    <main>
    <section class="one-seminar">
        <?php if($seminars === null): ?>
            <p>Seminář nenalezen</p>

        <?php else: ?>
            <div class="one-seminar-box">
                <h2><?php echo htmlspecialchars($seminars["name"])?></2h>
                <h3><?= htmlspecialchars($seminars["lector"])?></h3>
                <p>Datum: <?= htmlspecialchars(date("j. n. Y.", strtotime($seminars["date"]))) ?></p>
                <p>Popis: <?= htmlspecialchars($seminars["description"]) ?></p>
                <p>Cena: <?= htmlspecialchars($seminars["price"]) ?>,-Kč</p>
            </div>
        <?php endif ?>
        <div class="button">
        <a href="https://forms.gle/t3rcMqtBqrK141t86" target="_blank">Přihlásit se</a><br>
        </div>
        <?php if($role === "admin"): ?>
            <div class="buttons">
                <a href="editseminar.php?id=<?= $seminars['id']?>">Upravit</a>
                <a href="delseminar.php?id=<?= $seminars['id']?>">Smazat</a>
                <form action="archiv.php?id=<?= $seminars['id']?>" method="post">
                
                <br><br>
                <a href="seminars.php">Zpět na výpis seminářů</a>
                <br><br><br><br><br><br>
                <p>Tohle tlačítko vezme všechny minulé semináře a přesune je do proběhlých seminářů.</p>
                <button type="submit" name="archiv">Archivovat</button>
                </form>
            </div>
        <?php endif; ?>
    </section>
</main>
<?php require "../assets/footer.php";?>
</body>
<script src="../js/header.js"></script>
</html>