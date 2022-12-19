<?php
//nástroje
require_once $_SERVER["DOCUMENT_ROOT"] . "/tools.php";

//GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (
        preg_match(
            "/^\/albums\/edit\?id_album=[0-9]+$/",
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
    $id = $_POST["id_album"];
    $name = $_POST["name_album"];
    $type = $_POST["id_type"];
    $released = $_POST["released_album"];
    $interpret = $_POST["id_interpret"];
    $genreIds = $_POST["ids_genres"];

    $albumCount; //alba
    $typeCount; //typy alb
    $interpretCount; //interpreti
    //validace
    //https://stackoverflow.com/questions/3011383/preg-match-unknown-modifier-help
    if (
        preg_match("/^[0-9]+$/", $id) &&
        preg_match('#^[^"\']+$#', $name) &&
        preg_match("/^[0-9]+$/", $type) &&
        isValidYmd($released) &&
        preg_match("/^([0-9]+|NULL)$/", $interpret)
    ) {
        $interpretExists = true;
        $albumCount = querySqlSingle(
            "SELECT COUNT(*) FROM albums WHERE id_album = " . $id . ";"
        );
        $typeCount = querySqlSingle(
            "SELECT COUNT(*) FROM album_types WHERE id_type = " . $type . ";"
        );
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
        $validGenres = true;
        if (empty($genreIds) == false) {
            for ($i = 0; $i < count($genreIds); $i++) {
                $count = querySqlSingle(
                    "SELECT COUNT(*) FROM genres WHERE id_genre = " .
                        $genreIds[$i] .
                        ";"
                );
                if ($count != 1) {
                    $validGenres = false;
                    break;
                }
            }
        }

        //pokud existují
        if (
            $albumCount == 1 &&
            $typeCount == 1 &&
            $interpretExists &&
            $validGenres
        ) {
            //aktualizace
            $success = querySqlExec(
                "UPDATE albums SET name_album = '" .
                    $name .
                    "', id_type = " .
                    $type .
                    ", released_album = " .
                    convertYmdToEpochTime($released) .
                    ",id_interpret = " .
                    $interpret .
                    " WHERE id_album = " .
                    $id .
                    ";"
            );
            if ($success) {
                $success = querySqlExec(
                    "DELETE FROM album_genres WHERE id_album = " . $id . ";"
                );
            }
            if ($success && empty($genreIds) == false) {
                for ($i = 0; $i < count($genreIds); $i++) {
                    $success = querySqlExec(
                        "INSERT INTO album_genres (id_album, id_genre) VALUES (" .
                            $id .
                            ", " .
                            $genreIds[$i] .
                            ");"
                    );
                    if ($success == false) {
                        break;
                    }
                }
            }

            if ($success) {
                header("Location: /albums/edit?id_album=" . $id);
            } else {
                $errorTitle = "Chyba";
                $errorText = "Album se nepodařilo aktualizovat.";
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

$id = $_GET["id_album"];
//kontrola, jestli záznam existuje
$count = querySqlSingle(
    "SELECT COUNT(*) FROM albums WHERE id_album = " . $id . ";"
);

if ($count == 1) {
    //album
    $albumResult = querySql(
        "SELECT name_album, id_type, released_album, id_interpret FROM albums WHERE id_album = " .
            $id .
            ";"
    );
    $album;
    while ($row = $albumResult->fetchArray()) {
        $album = $row;
    }
    //žánry alba
    $albumGenresResult = querySql(
        "SELECT id_genre FROM album_genres WHERE id_album = " . $id . ";"
    );
    $genres = [];
    while ($row = $albumGenresResult->fetchArray()) {
        array_push($genres, $row["id_genre"]);
    }
    //typy alb
    $typesResult = querySql("SELECT id_type, name_type FROM album_types;");
    //interpreti
    $interpretsResult = querySql(
        "SELECT id_interpret, name_interpret FROM interprets;"
    );
    //žánry alb
    $genresResult = querySql("SELECT id_genre, name_genre FROM genres;");
} else {
    $errorTitle = "Chyba";
    $errorText = "Album v databázi neexistuje.";
    include $_SERVER["DOCUMENT_ROOT"] . "/error.php";
}
?>

<div class="py-5 section-fade-in h-100" style="background-image: url(/images/nirvana.jpg);	background-position: center;	background-size: cover;	background-repeat: no-repeat;">
  <div class="container">
    <div class="row mx-auto">
      <div class="col-md-12">
        <form class="w-75 mx-auto mt-4" action="/albums/edit" method="post">
          <input type="hidden" class="form-control" name="id_album" value="<?php echo $id;
//id alba
?>" required>
          <div class="form-group row">
            <label class="col-2 col-form-label">Název</label>
            <div class="col-10">
              <input type="text" class="form-control" name="name_album" value="<?php echo $album[
                  "name_album"
              ];
//název alba
?>" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-2 col-form-label">Typ</label>
            <div class="col-10">
              <select class="form-control" name="id_type" required>
                <?php //vygenerování typů

while ($row = $typesResult->fetchArray()) {
                    $selected = "";
                    //pokud je typ vybrán
                    if ($album["id_type"] == $row["id_type"]) {
                        $selected = " selected";
                    }
                    echo '<option value="' .
                        $row["id_type"] .
                        '"' .
                        $selected .
                        ">" .
                        $row["name_type"] .
                        "</option>" .
                        "\n";
                } ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-2 col-form-label">Vydáno</label>
            <div class="col-10">
              <!-- https://stackoverflow.com/questions/14212527/how-to-set-default-value-to-the-inputtype-date/14212715#14212715 --->
              <input type="date" class="form-control" name="released_album" value="<?php echo convertEpochTimeInput(
                  $album["released_album"]
              );
//datum vydání
?>" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-2 col-form-label">Interpret</label>
            <div class="col-10">
              <select class="form-control" name="id_interpret" required>
                <option value="NULL" <?php if (empty($album["id_interpret"])) {
                    echo "selected";
                } ?>>Žádný interpret</option>
                <?php //vygenerování interpretů

while ($row = $interpretsResult->fetchArray()) {
                    $selected = "";
                    //pokud je interpret vybrán
                    if ($album["id_interpret"] == $row["id_interpret"]) {
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
          <div class="form-group row">
            <label class="col-2 col-form-label">Žánry</label>
            <div class="col-10">
              <select class="form-control" name="ids_genres[]" multiple>
                <?php //vygenerování žánrů

while ($row = $genresResult->fetchArray()) {
                    $selected = "";
                    //pokud je žánr vybrán
                    if (in_array($row["id_genre"], $genres)) {
                        $selected = " selected";
                    }
                    echo '<option value="' .
                        $row["id_genre"] .
                        '"' .
                        $selected .
                        ">" .
                        $row["name_genre"] .
                        "</option>" .
                        "\n";
                } ?>
              </select>
            </div>
          </div>
          <button type="submit" class="btn btn-primary ml-auto mt-3 mr-2" >Aktualizovat</button>
            <a class="btn btn-primary ml-2 mr-auto mt-3" href="/albums">Zpět</a>
        </form>
      </div>
    </div>
  </div>
</div>