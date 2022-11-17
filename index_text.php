<?php
//kontrola cesty, aby se nešlo dostat na skript generující text
if ($_SERVER["REQUEST_URI"] == "/") {
    //platná cesta
  
    echo "<h1>Hlavní stránka</h1>";
    echo "Verze PHP: " . phpversion();
} else {
    //neplatná cesta
    echo "Chyba v Matrixu";
}
?>
