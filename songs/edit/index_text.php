<?php
//nástroje
require_once $_SERVER["DOCUMENT_ROOT"] . "/tools.php";

//GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (
        preg_match("/\/songs\/edit\?id_song=[0-9]+/i", $_SERVER["REQUEST_URI"]) == false
    ) {
        exit();
    }
}
//POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //atributy
    $id = $_POST["id_song"];
    $name = $_POST["name_song"];
    $album = $_POST["id_album"];
    $interpret = $_POST["id_interpret"];

    $songCount; //skladby
    $albumCount; //alba
    $interpretCount; //interpreti
    //valdiace
    if (
        empty($id) == false &&
        empty($name) == false &&
        empty($album) == false &&
        empty($interpret) == false
    ) {
        $songCount = querySqlSingle(
            "SELECT COUNT(*) FROM songs WHERE id_song = " . $id . ";"
        );
        $albumCount = querySqlSingle(
            "SELECT COUNT(*) FROM albums WHERE id_album = " . $album . ";"
        );
        $interpretCount = querySqlSingle(
            "SELECT COUNT(*) FROM interprets WHERE id_interpret = " .
                $interpret .
                ";"
        );

        //pokud existují
        if ($songCount == 1 && $albumCount == 1 && $interpretCount == 1) {
            //aktualizace
            $success = querySqlExec(
                "UPDATE songs SET name_song = '" .
                    $name .
                    "', id_album = " .
                    $album .
                    ", id_interpret = " .
                    $interpret .
                    " WHERE id_song = " .
                    $id .
                    ";"
            );

            if ($success) {
                header("Location: /songs/edit?id_song=" . $id);
            }
        }
    }
    
    exit();
}

$id = $_GET["id_song"];
//kontrola, jestli záznam existuje
$count = querySqlSingle(
    "SELECT COUNT(*) FROM songs WHERE id_song = " . $id . ";"
);

if ($count == 1) {
    //skladba
    $songResult = querySql(
        "SELECT name_song, albums.id_album, interprets.id_interpret FROM songs INNER JOIN albums ON songs.id_album = albums.id_album INNER JOIN interprets ON songs.id_interpret = interprets.id_interpret WHERE id_song = " .
            $id .
            ";"
    );
    $song;
    while ($row = $songResult->fetchArray()) {
        $song = $row;
    }
    //interpreti
    $albumsResult = querySql(
        "SELECT id_interpret, name_interpret FROM interprets;"
    );
} else {
    exit();
}
?>

<div class="py-5 section-fade-in h-100" style="background-image: url(/images/nirvana.jpg);	background-position: center;	background-size: cover;	background-repeat: no-repeat;">
  <div class="container">
    <div class="row mx-auto">
      <div class="col-md-12">
        <form class="w-75 mx-auto mt-4" action="/songs/edit" method="post">
          <input type="hidden" class="form-control" required="required" name="id_song" value="<?php echo $id;
//id skladby
?>">
          <div class="form-group row">
            <label class="col-2 col-form-label">Název</label>
            <div class="col-10">
              <input type="text" class="form-control" required="required" name="name_song" value="<?php echo $song[
                  "name_song"
              ];
//název skladby
?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-2 col-form-label">Album</label>
            <div class="col-10">
              <select class="form-control" name="id_album">
                <?php
                //alba
                $albumsResult = querySql(
                    "SELECT id_album, name_album FROM albums;"
                );
                //vygenerování alb
                while ($row = $albumsResult->fetchArray()) {
                    $selected = "";
                    //pokud je album vybráno
                    if ($song["id_album"] == $row["id_album"]) {
                        $selected = " selected";
                    }
                    echo '<option value="' .
                        $row["id_album"] .
                        '"' .
                        $selected .
                        ">" .
                        $row["name_album"] .
                        "</option>" .
                        "\n";
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-2 col-form-label">Interpret</label>
            <div class="col-10">
              <select class="form-control" name="id_interpret">
                <?php
                //interpreti
                $interpretsResult = querySql(
                    "SELECT id_interpret, name_interpret FROM interprets;"
                );
                //vygenerování alb
                while ($row = $interpretsResult->fetchArray()) {
                    $selected = "";
                    //pokud je album vybráno
                    if ($song["id_interpret"] == $row["id_interpret"]) {
                        $selected = " selected";
                    }
                    echo '<option value="' .
                        $row["id_interpret"] .
                        '"' .
                        $selected .
                        ">" .
                        $row["name_interpret"] .
                        "</option>" .
                        "\n";
                }
                ?>
              </select>
            </div>
            <button type="submit" class="btn btn-primary ml-auto mt-3 mr-2" >Aktualizovat</button>
            <a class="btn btn-primary ml-2 mr-auto mt-3" href="/songs">Zpět</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>