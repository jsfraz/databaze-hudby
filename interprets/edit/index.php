<?php
//editace interpreta

//Oprava chyby "Cannot modify header information" při aktualizování interpreta, funguje a nevím proč. Zázrak.
//https://stackoverflow.com/questions/6974691/php-page-redirect-problem-cannot-modify-header-information
ob_start();

$content = "index_text.php";    //skript generující text
include $_SERVER['DOCUMENT_ROOT'] . "/master.php";    //šablona
?>