<?php

require "../classes/Url.php";
require "../classes/User.php";
require "../classes/Db.php";

session_start();

if($_SERVER["REQUEST_METHOD"] === "POST") {

    $database = new Database(); 
    $connection = $database->connectionDB();

    $first_name = $_POST["first_name"];
    $second_name = $_POST["second_name"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = "user";

    $id = User::createUser($connection, $first_name, $second_name, $email, $password, $role);
    
    if(!empty($id)) {
        session_regenerate_id(true); 
        
       
        $_SESSION["is_logged_in"] = true;
    
        $_SESSION["logged_in_user_id"] = $id;
        
        $_SESSION["role"] = $role;

        Url::redirectUrl("/web/shibumi23/admin/seminars.php"); 
    } else {
        echo "Uživatele se nepodařilo přidat";
    }
   
}





?>