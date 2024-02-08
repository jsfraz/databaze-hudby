<?php
if ($_SERVER["REQUEST_URI"] != "/albums/insert") {
    exit();
}

//nástroje
require_once $_SERVER["DOCUMENT_ROOT"] . "/tools.php";

//POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //atributy
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
        preg_match('#^[^"\']+$#', $name) &&
        preg_match("/^[0-9]+$/", $type) &&
        isValidYmd($released) &&
        preg_match("/^([0-9]+|NULL)$/", $interpret)
    ) {
        $interpretExists = true;

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
        if ($typeCount == 1 && $interpretExists && $validGenres) {
            //vložení
            $db = getSqliteConnection();
            $success = querySqlExecCustom(
                $db,
                "INSERT INTO albums (name_album, id_type, released_album, id_interpret) VALUES ('" .
                    $name .
                    "', " .
                    $type .
                    ", " .
                    convertYmdToEpochTime($released) .
                    ", " .
                    $interpret .
                    ");"
            );
            $id = $db->lastInsertRowId();
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
                //id posledního vloženého řádku: https://stackoverflow.com/questions/8892973/how-to-get-last-insert-id-in-sqlite
                header("Location: /albums/edit?id_album=" . $id);
            } else {
                $errorTitle = "Chyba";
                $errorText = "Nepodařilo se přidat album.";
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

//typy
$typesResult = querySql("SELECT id_type, name_type FROM album_types;");
//interpreti
$interpretsResult = querySql(
    "SELECT id_interpret, name_interpret FROM interprets;"
);
//žánry alb
$genresResult = querySql("SELECT id_genre, name_genre FROM genres;");
?>

<div class="py-5 section-fade-in h-100" style="background-image: url(/images/nirvana.jpg);	background-position: center;	background-size: cover;	background-repeat: no-repeat;">
  <div class="container">
    <div class="row mx-auto">
      <div class="col-md-12">
        <form class="w-75 mx-auto mt-4" action="/albums/insert" method="post">
          <div class="form-group row">
            <label class="col-2 col-form-label">Název</label>
            <div class="col-10">
              <input type="text" class="form-control" name="name_album" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-2 col-form-label">Typ</label>
            <div class="col-10">
              <select class="form-control" name="id_type" required>
                <?php //vygenerování typů

while ($row = $typesResult->fetchArray()) {
                    echo '<option value="' .
                        $row["id_type"] .
                        '">' .
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
              <input type="date" class="form-control" name="released_album" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-2 col-form-label">Interpret</label>
            <div class="col-10">
              <select class="form-control" name="id_interpret" required>
                <option value="NULL" selected>Žádný interpret</option>
                <?php //vygenerování interpretů

while ($row = $interpretsResult->fetchArray()) {
                    echo '<option value="' .
                        $row["id_interpret"] .
                        '">' .
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
          <button type="submit" class="btn btn-primary ml-auto mt-3 mr-2" >Přidat</button>
            <a class="btn btn-primary ml-2 mr-auto mt-3" href="/albums">Zpět</a>
        </form>
      </div>
    </div>
  </div>
</div>