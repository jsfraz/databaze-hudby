<?php
//nástroje
require_once $_SERVER["DOCUMENT_ROOT"] . "/tools.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id_album"];

    if (preg_match("/^[0-9]+$/", $id)) {
        $count = querySqlSingle(
            "SELECT COUNT(*) FROM albums WHERE id_album = " . $id . ";"
        );

        //pokud existuje
        if ($count == 1) {
            //smazání
            querySqlExec("DELETE FROM albums WHERE id_album = " . $id . ";");
            querySqlExec("DELETE FROM album_genres WHERE id_album = " . $id . ";");
            querySqlExec("UPDATE songs SET id_album = NULL WHERE id_album = " . $id . ";");
            header("Location: /albums");
            exit();
        } else {
            $errorTitle = "Chyba";
            $errorText = "Album v databázi neexistuje.";
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
