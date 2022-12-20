<?php
//nástroje
require_once $_SERVER["DOCUMENT_ROOT"] . "/tools.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id_interpret"];

    if (preg_match("/^[0-9]+$/", $id)) {
        $count = querySqlSingle(
            "SELECT COUNT(*) FROM interprets WHERE id_interpret = " . $id . ";"
        );

        //pokud existuje
        if ($count == 1) {
            //smazání
            querySqlExec("DELETE FROM interprets WHERE id_interpret = " . $id . ";");
            querySqlExec("UPDATE albums SET id_interpret = NULL WHERE id_interpret = " . $id . ";");
            querySqlExec("UPDATE songs SET id_interpret = NULL WHERE id_interpret = " . $id . ";");
            header("Location: /interprets");
            exit();
        } else {
            $errorTitle = "Chyba";
            $errorText = "Interpret v databázi neexistuje.";
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
