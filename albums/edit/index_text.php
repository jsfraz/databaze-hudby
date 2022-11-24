<?php
//nástroje
require_once $_SERVER["DOCUMENT_ROOT"] . "/tools.php";

//GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (
        preg_match("/\/albums\/edit\?id_album=[0-9]+/i", $_SERVER["REQUEST_URI"]) == false
    ) {
        exit();
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

    $albumCount; //alba
    $typeCount; //typy alb
    $interpretCount; //interpreti
    //valdiace
    if (
        empty($id) == false &&
        empty($name) == false &&
        empty($type) == false &&
        empty($released) == false &&
        empty($interpret) == false
    ) {
        $albumCount = querySqlSingle(
            "SELECT COUNT(*) FROM albums WHERE id_album = " . $id . ";"
        );
        $typeCount = querySqlSingle(
            "SELECT COUNT(*) FROM album_types WHERE id_type = " . $type . ";"
        );
        $interpretCount = querySqlSingle(
            "SELECT COUNT(*) FROM interprets WHERE id_interpret = " .
                $interpret .
                ";"
        );

        //pokud existují
        if ($albumCount == 1 && $typeCount == 1 && $interpretCount == 1) {
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
                header("Location: /albums/edit?id_album=" . $id);
            }
        }
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
    //typy alb
    $typesResult = querySql(
        "SELECT id_type, name_type FROM album_types;"
    );
    //interpreti
    $interpretsResult = querySql(
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
        <form class="w-75 mx-auto mt-4" action="/albums/edit" method="post">
          <input type="hidden" class="form-control" required="required" name="id_album" value="<?php echo $id;
//id alba
?>">
          <div class="form-group row">
            <label class="col-2 col-form-label">Název</label>
            <div class="col-10">
              <input type="text" class="form-control" required="required" name="name_album" value="<?php echo $album[
                  "name_album"
              ];
//název alba
?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-2 col-form-label">Typ</label>
            <div class="col-10">
              <select class="form-control" name="id_type">
                <?php
                //vygenerování typů
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
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-2 col-form-label">Vydáno</label>
            <div class="col-10">
              <!-- https://stackoverflow.com/questions/14212527/how-to-set-default-value-to-the-inputtype-date/14212715#14212715 --->
              <input type="date" class="form-control" required="required" name="released_album" value="<?php echo convertEpochTimeInput($album["released_album"]);//datum vydání?>">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-2 col-form-label">Interpret</label>
            <div class="col-10">
              <select class="form-control" name="id_interpret">
                <?php
                //vygenerování interpretů
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
                }
                ?>
              </select>
            </div>
            <button type="submit" class="btn btn-primary ml-auto mt-3 mr-2" >Aktualizovat</button>
            <a class="btn btn-primary ml-2 mr-auto mt-3" href="/albums">Zpět</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>