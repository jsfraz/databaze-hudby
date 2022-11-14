<?php
//nástroje
require_once("../tools.php");

$result = querySql("SELECT id_song, name_song, name_album, name_interpret FROM songs INNER JOIN albums ON songs.id_album = albums.id_album INNER JOIN interprets ON songs.id_interpret = interprets.id_interpret;");
if ($result->num_rows > 0) {
    echo '
<table style="width:100%">
	<tr>
		<th>ID</th>
		<th>Jméno</th>
		<th>Album</th>
		<th>Interpret</th>
	</tr>';
    //output
    while ($row = $result->fetch_assoc()) {
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
    echo "0 results";
}
?>
