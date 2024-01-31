<?php

require_once(__DIR__."/../classes/Db.php");
require_once(__DIR__."/../classes/Auth.php");
require_once(__DIR__."/../classes/Seminar.php");
require_once(__DIR__."/../classes/Url.php");

session_start();

if(!Auth::isLoggedIn()) {
    die("nepovolený přístup!");
}

$role=$_SESSION["role"];

$database = new Database();
$connection = $database->connectionDB();

$name = null;
$lector = null;
$description = null;
$price = null;
$date = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
 var_dump($_POST);

    $name = $_POST["name"];
    $lector = $_POST["lector"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $date = $_POST["date"];
    $id = Seminar::create_seminar($connection, $name, $lector, $description, $price, $date);

    if($id) {
        Url::redirectUrl("/web/shibumi23/admin/oneseminar.php?id=$id");
    } else {
        echo "Seminář nebyl vytvořen!";
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../css/general.css">
    <script src="https://kit.fontawesome.com/f3c1d6cf9d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../query/header-query.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/addseminar.css">
    <link rel="stylesheet" href="../query/addseminar-query.css">
    <title>Document</title>
</head>
<body>
    <?php require "../assets/admin-header.php";?>

    <main>

    
        <section class="add-form">
            <h1>Pro přidání semináře vyplňte následující formulář:</h1><br>
            <?php require "../assets/form-seminar.php";?>
        </section>
    </main>
    <?php require "../assets/footer.php";?>
</body>
<script src="../js/header.js"></script>
</html>
