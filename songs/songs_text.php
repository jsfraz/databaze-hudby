<?php
//kontrola cesty, aby se nešlo dostat na skript generující text
if ($_SERVER["REQUEST_URI"] == "/songs") {
    //platná cesta

    //nástroje
    require_once "../tools.php";

    //dotaz na všechny skladby
    $result = querySql(
        "SELECT id_song, name_song, name_album, name_interpret FROM songs INNER JOIN albums ON songs.id_album = albums.id_album INNER JOIN interprets ON songs.id_interpret = interprets.id_interpret;"
    );

    //kontrola počtu řádků
    if (countRows($result) > 0) {
        //jeden a více výsledků

        //hlavička tabulky
        echo '
<table style="width:100%">
	<tr>
		<th>ID</th>
		<th>Jméno</th>
		<th>Album</th>
		<th>Interpret</th>
	</tr>';
        //vypsání skladeb
        while ($row = $result->fetchArray()) {
            echo "
	<tr>
		<td>" .
                $row["id_song"] .
                "</td>
		<td>" .
                $row["name_song"] .
                "</td>
		<td>" .
                $row["name_album"] .
                "</td>
		<td>" .
                $row["name_interpret"] .
                "</td>
	</tr>";
        }
        echo "
</table>";
    } else {
        //nula výsledků
        echo "0 results";
    }
} else {
    //neplatná cesta
    echo "Chyba v Matrixu";
}
?>