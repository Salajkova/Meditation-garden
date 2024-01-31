<?php

require_once(__DIR__."/../classes/Db.php");
require_once(__DIR__."/../classes/Url.php");
require_once(__DIR__."/../classes/User.php");

session_start();

if($_SERVER["REQUEST_METHOD"] === "POST") {

    $database = new Database(); 
    $connection = $database->connectionDB();


    $log_email = $_POST["email"];
    $log_password = $_POST["password"];
    
 if(User::authentication($connection, $log_email, $log_password)) {
    
    $id = User::getUserId($connection, $log_email);

    session_regenerate_id(true); 
       $_SESSION["is_logged_in"] = true;
       
       $_SESSION["logged_in_user_id"] = $id;
       
       $_SESSION["role"] = User::getUserRole($connection, $id);

       Url::redirectUrl("/web/shibumi23/admin/seminars.php");

 } else {

$error = "Chyba při přihlášení";
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
    <?php if(!empty($error)): ?>
        <p><?= $error ?> </p>
        <a href="../signin.php">Zpět na přihlášení</a>

        <?php endif; ?>
</body>
</html>