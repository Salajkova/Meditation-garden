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

if(isset($_GET["id"])) {
    $one_seminar = Seminar::get_seminar($connection, $_GET["id"]);

    if($one_seminar) {

        $name = $one_seminar["name"];
        $lector = $one_seminar["lector"];
        $description = $one_seminar["description"];
        $price = $one_seminar["price"];
        $date = $one_seminar["date"];
        $id = $one_seminar["id"];
        
    } else {
        die("Seminář nenalezen!");
    }
} else {
    die("id není zadáno!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $name = $_POST["name"];
    $lector = $_POST["lector"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $date = $_POST["date"];

    if(Seminar::update_seminar($connection, $name, 
    $lector,  $description, $price, $date, $id)) {
        Url::redirectUrl("/web/shibumi23/admin/oneseminar.php?id=$id");
    };
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
    <link rel="stylesheet" href="../css/editseminar.css">
    <link rel="stylesheet" href="../query/editseminar-query.css">
    <title>Meditační zahrada SHIBUMI</title>
</head>
<body>
<?php require "../assets/admin-header.php";?>

<main>
    <h2>Zde upravte seminář</h2>
 <?php
 if($role === "admin") {
    require "../assets/form-seminar.php";
 } else {
    echo "<h1> Obsah stránky je k dispozici pouze administrátorům</h1>";
 }?>


</main>
<?php require "../assets/footer.php";?>
</body>
<script src="../js/header.js"></script>
</html>