<?php
//nástroje
require_once $_SERVER["DOCUMENT_ROOT"] . "/tools.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id_song"];

    if (preg_match("/^[0-9]+$/", $id)) {
        $count = querySqlSingle(
            "SELECT COUNT(*) FROM songs WHERE id_song = " . $id . ";"
        );

        //pokud existuje
        if ($count == 1) {
            //smazání
            querySqlExec("DELETE FROM songs WHERE id_song = " . $id . ";");
            header("Location: /songs");
            exit();
        } else {
            $errorTitle = "Chyba";
            $errorText = "Skladba v databázi neexistuje.";
            include $_SERVER["DOCUMENT_ROOT"] . "/error.php";
        }
    } else {
        $errorTitle = "Chyba";
        $errorText = "Neplatný požadavek.";
        include $_SERVER["DOCUMENT_ROOT"] . "/error.php";
    }
} else {
    $errorTitle = "Chyba";
    $errorText = "Neplatný požadavek.";
    include $_SERVER["DOCUMENT_ROOT"] . "/error.php";
}
?>
