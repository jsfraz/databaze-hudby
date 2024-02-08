<?php
//nástroje
require_once $_SERVER["DOCUMENT_ROOT"] . "/tools.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id_genre"];

    if (preg_match("/^[0-9]+$/", $id)) {
        $count = querySqlSingle(
            "SELECT COUNT(*) FROM genres WHERE id_genre = " . $id . ";"
        );

        //pokud existuje
        if ($count == 1) {
            //smazání
            querySqlExec("DELETE FROM genres WHERE id_genre = " . $id . ";");
            querySqlExec("DELETE FROM album_genres WHERE id_genre = " . $id . ";");
            header("Location: /genres");
            exit();
        } else {
            $errorTitle = "Chyba";
            $errorText = "Žánr v databázi neexistuje.";
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
