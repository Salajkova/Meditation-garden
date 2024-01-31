<?php

require_once(__DIR__."/../classes/Db.php");
require_once(__DIR__."/../classes/Auth.php");
require_once(__DIR__."/../classes/Seminar.php");


session_start();

$role = isset($_SESSION["role"]) ? $_SESSION["role"] : "guest";

$database = new Database();
$connection = $database->connectionDB();

$seminars = Seminar::getAllSeminars($connection, "id, name, lector, date, description, price");
$old_seminars = Seminar::getAllOldSeminars($connection, "id, name, lector, date, description, price");

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
    <link rel="stylesheet" href="../css/seminars.css">
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../query/general-query.css">
    <title>Meditační zahrada SHIBUMI</title>
</head>
<body>
<?php require "../assets/admin-header.php";?>
    <main>
        <section class="mainheading">
        <h1>Semináře pro rok <?php echo date('Y'); ?></h1>
        
        
        </section>
        <section class="link-container">
            <p id="link1" onclick="displayPage('1')" class="link active">Aktuální</p> 
            <p id="link2" onclick="displayPage('2')" class="link active">Minulé</p> 
    
        </section>
      
        
        <?php if($role === "admin"): ?>
      <div class="adder">      <a href="addseminar.php">Přidat&nbsp;seminář</a> </div>  <?php endif; ?>
        
      <div id="page1" class="page active">

        <section class="seminars">

        <?php if(empty($seminars)):?>
            <p>Zatím nebyly vypsány žádné semináře</p>
            <?php else: ?>
                <div class="all-seminars">
                    <?php foreach($seminars as $one_seminar):?>
                        <div class="one-seminar">
                            <h2><?php echo htmlspecialchars($one_seminar["name"])?></h2>
                            <h3><?php echo htmlspecialchars($one_seminar["lector"]) ?></h3>
                            <p> Datum: <?= htmlspecialchars(date("j. n. Y.", strtotime($one_seminar["date"]))) ?></p>
                            <p> Popis: <?= htmlspecialchars($one_seminar["description"]) ?></p>
                            <p> Cena: <?= htmlspecialchars($one_seminar["price"]) ?> Kč,-</p>
                            
                            <a href="https://forms.gle/t3rcMqtBqrK141t86" target="_blank">Přihlásit se</a><br>
                            
                            <?php if($role === "admin"): ?>  <a href='oneseminar.php?id=<?=$one_seminar["id"]?>'>Upravit</a><?php endif; ?>
                        </div>
                        <?php endforeach ?>
                </div>
                <?php endif?>

        </section>
                            </div>

                            <div id="page2" class="page">
                       
        <section class="old_old_seminar">
            <?php if (empty($old_seminars)) : ?> 
                
                <p>Zatím neproběhly žádné staré semináře</p>
            <?php else : ?>
                <div class="all-old_seminars">
                    <?php foreach ($old_seminars as $one_old_seminar) : ?>
                        <div class="one-old_seminar">
                            <h2><?php echo htmlspecialchars($one_old_seminar["name"]) . "<br>" .
                                htmlspecialchars($one_old_seminar["lector"]) ?></h2>
                            <p> Popis: <?= htmlspecialchars($one_old_seminar["description"]) ?></p>
                            
                        </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
                    </div>
        </section>
                    </main>
                    <?php require "../assets/footer.php";?>
</body>
<script src="../js/header.js"></script>

<script src="../js/galerry.js"></script>


</html>