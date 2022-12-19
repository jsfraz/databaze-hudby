<?php
//nástroje
require_once $_SERVER["DOCUMENT_ROOT"] . "/tools.php";

//GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (
        preg_match(
            "/^\/songs\/edit\?id_song=[0-9]+$/",
            $_SERVER["REQUEST_URI"]
        ) == false
    ) {
        $errorTitle = "Chyba";
        $errorText = "Neplatný požadavek.";
        include $_SERVER["DOCUMENT_ROOT"] . "/error.php";
    }
}
//POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //atributy
    $id = $_POST["id_song"];
    $name = $_POST["name_song"];
    $album = $_POST["id_album"];
    $interpret = $_POST["id_interpret"];

    //validace
    if (
        preg_match("/^[0-9]+$/", $id) &&
        preg_match('#^[^"\']+$#', $name) &&
        preg_match("/^([0-9]+|NULL)$/", $album) &&
        preg_match("/^([0-9]+|NULL)$/", $interpret)
    ) {
        $songCount;
        $albumExists = true;
        $interpretExists = true;

        $songCount = querySqlSingle(
            "SELECT COUNT(*) FROM songs WHERE id_song = " . $id . ";"
        );
        if ($album != "NULL") {
            $albumCount = querySqlSingle(
                "SELECT COUNT(*) FROM albums WHERE id_album = " . $album . ";"
            );
            if ($albumCount != 1) {
                $albumExists = false;
            }
        }
        if ($interpret != "NULL") {
            $interpretCount = querySqlSingle(
                "SELECT COUNT(*) FROM interprets WHERE id_interpret = " .
                    $interpret .
                    ";"
            );
            if ($interpretCount != 1) {
                $interpretExists = false;
            }
        }

        //pokud existují
        if ($songCount == 1 && $albumExists && $interpretExists) {
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
            } else {
                $errorTitle = "Chyba";
                $errorText = "Skladbu se nepodařilo aktualizovat.";
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
        "SELECT name_song, id_album, id_interpret FROM songs WHERE id_song = " .
            $id .
            ";"
    );
    $song;
    while ($row = $songResult->fetchArray()) {
        $song = $row;
    }
    //alba
    $albumsResult = querySql("SELECT id_album, name_album FROM albums;");
    //interpreti
    $interpretsResult = querySql(
        "SELECT id_interpret, name_interpret FROM interprets;"
    );
} else {
    $errorTitle = "Chyba";
    $errorText = "Skladba v databázi neexistuje.";
    include $_SERVER["DOCUMENT_ROOT"] . "/error.php";
}
?>

<div class="py-5 section-fade-in h-100" style="background-image: url(/images/nirvana.jpg);	background-position: center;	background-size: cover;	background-repeat: no-repeat;">
  <div class="container">
    <div class="row mx-auto">
      <div class="col-md-12">
        <form class="w-75 mx-auto mt-4" action="/songs/edit" method="post">
          <input type="hidden" class="form-control" name="id_song" value="<?php echo $id;
//id skladby
?>" required>
          <div class="form-group row">
            <label class="col-2 col-form-label">Název</label>
            <div class="col-10">
              <input type="text" class="form-control" name="name_song" value="<?php echo $song[
                  "name_song"
              ];
//název skladby
?>" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-2 col-form-label">Album</label>
            <div class="col-10">
              <select class="form-control" name="id_album" required>
                <option value="NULL" <?php if (empty($song["id_album"])) {
                    echo "selected";
                } ?>>Žádné album</option>
                <?php //vygenerování alb

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
                } ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-2 col-form-label">Interpret</label>
            <div class="col-10">
              <select class="form-control" name="id_interpret" required>
                <option value="NULL" <?php if (empty($song["id_interpret"])) {
                    echo "selected";
                } ?>>Žádný interpret</option>
                <?php //vygenerování interpretů

while ($row = $interpretsResult->fetchArray()) {
                    $selected = "";
                    //pokud je interpret vybrán
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
                } ?>
              </select>
            </div>
          </div>
          <button type="submit" class="btn btn-primary ml-auto mt-3 mr-2" >Aktualizovat</button>
            <a class="btn btn-primary ml-2 mr-auto mt-3" href="/songs">Zpět</a>
        </form>
      </div>
    </div>
  </div>
</div>