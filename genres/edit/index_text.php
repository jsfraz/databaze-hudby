<?php
//nástroje
require_once $_SERVER["DOCUMENT_ROOT"] . "/tools.php";

//GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (
        preg_match(
            "/^\/genres\/edit\?id_genre=[0-9]+$/",
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
    $id = $_POST["id_genre"];
    $name = $_POST["name_genre"];

    //validace
    if (preg_match("/^[0-9]+$/", $id) && preg_match('#^[^"\']+$#', $name)) {
        $genreCount = querySqlSingle(
            "SELECT COUNT(*) FROM genres WHERE id_genre = " . $id . ";"
        );

        //pokud existuje
        if ($genreCount == 1) {
            //aktualizace
            $success = querySqlExec(
                "UPDATE genres SET name_genre = '" . $name . "' WHERE id_genre = " . $id . ";"
            );

            if ($success) {
                header("Location: /genres/edit?id_genre=" . $id);
            } else {
                $errorTitle = "Chyba";
                $errorText = "Žánr se nepodařilo aktualizovat.";
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

$id = $_GET["id_genre"];
//kontrola, jestli záznam existuje
$count = querySqlSingle(
    "SELECT COUNT(*) FROM genres WHERE id_genre = " . $id . ";"
);

if ($count == 1) {
    //žánr
    $genresResult = querySql(
        "SELECT name_genre FROM genres WHERE id_genre = " . $id . ";"
    );
    $genre;
    while ($row = $genresResult->fetchArray()) {
        $genre = $row;
    }
} else {
    $errorTitle = "Chyba";
    $errorText = "Žánr v databázi neexistuje.";
    include $_SERVER["DOCUMENT_ROOT"] . "/error.php";
}
?>

<div class="py-5 section-fade-in h-100" style="background-image: url(/images/nirvana.jpg);	background-position: center;	background-size: cover;	background-repeat: no-repeat;">
  <div class="container">
    <div class="row mx-auto">
      <div class="col-md-12">
        <form class="w-75 mx-auto mt-4" action="/genres/edit" method="post">
          <input type="hidden" class="form-control" name="id_genre" value="<?php echo $id;
//id žánru
?>" required>
          <div class="form-group row">
            <label class="col-2 col-form-label">Název</label>
            <div class="col-10">
              <input type="text" class="form-control" name="name_genre" value="<?php echo $genre[
                  "name_genre"
              ];
//název žánru
?>" required>
            </div>
          </div>
          <button type="submit" class="btn btn-primary ml-auto mt-3 mr-2" >Aktualizovat</button>
            <a class="btn btn-primary ml-2 mr-auto mt-3" href="/genres">Zpět</a>
        </form>
      </div>
    </div>
  </div>
</div>