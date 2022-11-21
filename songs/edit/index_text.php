<?php
if (
    preg_match("/\/songs\/edit\?id=[0-9]+/i", $_SERVER["REQUEST_URI"]) &&
    $_SERVER["REQUEST_METHOD"] == "GET"
) {
    //pohoda
} else {
    echo "Chyba v Matrixu"; //TODO forbidden stránka
    exit();
}

//nástroje
require_once $_SERVER["DOCUMENT_ROOT"] . "/tools.php";

$id = $_GET["id"];
//kontrola, jestli záznam existuje
$count = querySqlSingle(
    "SELECT COUNT(*) FROM songs WHERE id_song = " . $id . ";"
);

if ($count == 1) {
    //skladba
    $songResult = querySql(
        "SELECT id_song, name_song, albums.id_album, interprets.id_interpret FROM songs INNER JOIN albums ON songs.id_album = albums.id_album INNER JOIN interprets ON songs.id_interpret = interprets.id_interpret WHERE id_song = " . $id . ";"
    );
    $song;
    while ($row = $songResult->fetchArray()) {
        $song = $row;
    }
    //interpreti
    $albumsResult = querySql("SELECT id_interpret, name_interpret FROM interprets;");
} else {
    //neexistuje
    //TODO oznámení chyby
    exit();
}
?>

<div class="py-5 section-fade-in h-100" style="background-image: url(/images/nirvana.jpg);	background-position: center;	background-size: cover;	background-repeat: no-repeat;">
  <div class="container">
    <div class="row mx-auto">
      <div class="col-md-12">
        <form class="w-75 mx-auto mt-4">
          <div class="form-group row">
            <label class="col-2 col-form-label">Název</label>
            <div class="col-10">
              <input type="text" class="form-control" required="required" name="name_song" value="<?php echo $song["name_song"]; ?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-2 col-form-label">Album</label>
            <div class="col-10">
              <select class="form-control" required="required" name="id_album">
                <?php
                //alba
                $albumsResult = querySql("SELECT id_album, name_album FROM albums;");
                //vygenerování alb
                while ($row = $albumsResult->fetchArray()) {
                  $selected = "";
                  //pokud je album vybráno
                  if ($song["id_album"] == $row["id_album"]) {
                    $selected = " selected";
                  }
                  echo '<option value="' . $row["id_album"] . '"' . $selected  . '>' . $row["name_album"] . '</option>' . "\n";
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-2 col-form-label">Interpret</label>
            <div class="col-10">
              <select class="form-control" required="required" name="id_interpret">
                <?php
                //interpreti
                $interpretsResult = querySql("SELECT id_interpret, name_interpret FROM interprets;");
                //vygenerování alb
                while ($row = $interpretsResult->fetchArray()) {
                  $selected = "";
                  //pokud je album vybráno
                  if ($song["id_interpret"] == $row["id_interpret"]) {
                    $selected = " selected";
                  }
                  echo '<option value="' . $row["id_interpret"] . '"' . $selected  . '>' . $row["name_interpret"] . '</option>' . "\n";
                }
                ?>
              </select>
            </div>
            <button type="submit" class="btn btn-primary mx-auto mt-3">Aktualizovat</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>