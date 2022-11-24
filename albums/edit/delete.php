<?php
//nástroje
require_once $_SERVER["DOCUMENT_ROOT"] . "/tools.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id_album"];

    if (empty($id) == false) {
        $count = querySqlSingle(
            "SELECT COUNT(*) FROM albums WHERE id_album = " . $id . ";"
        );

        //pokud existuje
        if ($count == 1) {
            //smazání
            querySqlExec("DELETE FROM albums WHERE id_album = " . $id . ";");
        }
        header("Location: /albums");
        exit();
    }
}
?>
