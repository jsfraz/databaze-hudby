<?php
if ($_SERVER["REQUEST_URI"] != "/songs/insert") {
    exit();
}

//nástroje
require_once $_SERVER["DOCUMENT_ROOT"] . "/tools.php";

//POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //atributy
    $name = $_POST["name_song"];
    $album = $_POST["id_album"];
    $interpret = $_POST["id_interpret"];

    //validace
    if (
        preg_match('#^[^"\']+$#', $name) &&
        preg_match("/^([0-9]+|NULL)$/", $album) &&
        preg_match("/^([0-9]+|NULL)$/", $interpret)
    ) {
        $albumExists = true;
        if ($album != "NULL") {
            $albumCount = querySqlSingle(
                "SELECT COUNT(*) FROM albums WHERE id_album = " . $album . ";"
            );
            if ($albumCount != 1) {
                $albumExists = false;
            }
        }
        $interpretExists = true;
        if ($interpret != "NULL") {
            $interpretCount = querySqlSingle(
                "SELECT COUNT(*) FROM interprets WHERE id_interpret = " .
                    $interpret .
                    ";"
            );
            if ($interpretCount != 1) {
                $interpretExists = fasle;
            }
        }

        //pokud existují
        if ($albumExists && $interpretExists) {
            //vložení
            $db = getSqliteConnection();
            $success = querySqlExecCustom(
                $db,
                "INSERT INTO songs (name_song, id_album, id_interpret) VALUES ('" .
                    $name .
                    "', " .
                    $album .
                    ", " .
                    $interpret .
                    ");"
            );

            if ($success) {
                //id posledního vloženého řádku: https://stackoverflow.com/questions/8892973/how-to-get-last-insert-id-in-sqlite
                $id = $db->lastInsertRowId();
                header("Location: /songs/edit?id_song=" . $id);
            } else {
                $errorTitle = "Chyba";
                $errorText = "Nepodařilo se přidat skladbu.";
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

//alba
$albumsResult = querySql("SELECT id_album, name_album FROM albums;");
//interpreti
$interpretsResult = querySql(
    "SELECT id_interpret, name_interpret FROM interprets;"
);
?>

<div class="py-5 section-fade-in h-100" style="background-image: url(/images/nirvana.jpg);	background-position: center;	background-size: cover;	background-repeat: no-repeat;">
  <div class="container">
    <div class="row mx-auto">
      <div class="col-md-12">
        <form class="w-75 mx-auto mt-4" action="/songs/insert" method="post">
          <div class="form-group row">
            <label class="col-2 col-form-label">Název</label>
            <div class="col-10">
              <input type="text" class="form-control" name="name_song" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-2 col-form-label">Album</label>
            <div class="col-10">
              <select class="form-control" name="id_album" required>
                <option value="NULL" selected>Žádné album</option>
                <?php //vygenerování alb

while ($row = $albumsResult->fetchArray()) {
                    echo '<option value="' .
                        $row["id_album"] .
                        '">' .
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
          <button type="submit" class="btn btn-primary ml-auto mt-3 mr-2" >Přidat</button>
            <a class="btn btn-primary ml-2 mr-auto mt-3" href="/songs">Zpět</a>
        </form>
      </div>
    </div>
  </div>
</div>