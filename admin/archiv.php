<?php
require_once(__DIR__."/../classes/Db.php");
require_once(__DIR__."/../classes/Auth.php");
require_once(__DIR__."/../classes/Seminar.php");
require_once(__DIR__."/../classes/Url.php");

session_start();

if (!Auth::isLoggedIn()) {
    die("Nepovolený přístup!");
}

$database = new Database();
$connection = $database->connectionDB();


// Pokus o archivaci semináře. Zatím neúspěšný. 

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["archiv"])) {
    // Získání všech seminářů, které již proběhly
    $archivSeminar = Seminar::getOldSeminar($connection);

    // Přesun seminářů do archivu
    foreach ($archivSeminar as $seminar) {
        $result = Seminar::archivSeminar($connection, $seminar["id"]);

        if (!$result) {
            echo "Chyba při archivaci semináře s ID: {$seminar['id']}";
            // Můžete přidat další opatření nebo přeskočit na další seminář
        }
    }

  Url::redirectUrl("/web/shibumi23/admin/seminars.php");
}
?>
