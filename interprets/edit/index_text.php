<?php
//nástroje
require_once $_SERVER["DOCUMENT_ROOT"] . "/tools.php";

//GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (
        preg_match(
            "/^\/interprets\/edit\?id_interpret=[0-9]+$/",
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
    $id = $_POST["id_interpret"];
    $name = $_POST["name_interpret"];

    //validace
    if (preg_match("/^[0-9]+$/", $id) && preg_match('#^[^"\']+$#', $name)) {
        $interpretCount = querySqlSingle(
            "SELECT COUNT(*) FROM interprets WHERE id_interpret = " . $id . ";"
        );

        //pokud existuje
        if ($interpretCount == 1) {
            //aktualizace
            $success = querySqlExec(
                "UPDATE interprets SET name_interpret = '" . $name . "' WHERE id_interpret = " . $id . ";"
            );

            if ($success) {
                header("Location: /interprets/edit?id_interpret=" . $id);
            } else {
                $errorTitle = "Chyba";
                $errorText = "Interpreta se nepodařilo aktualizovat.";
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

$id = $_GET["id_interpret"];
//kontrola, jestli záznam existuje
$count = querySqlSingle(
    "SELECT COUNT(*) FROM interprets WHERE id_interpret = " . $id . ";"
);

if ($count == 1) {
    //interpret
    $interpretsResult = querySql(
        "SELECT name_interpret FROM interprets WHERE id_interpret = " . $id . ";"
    );
    $interpret;
    while ($row = $interpretsResult->fetchArray()) {
        $interpret = $row;
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
        <form class="w-75 mx-auto mt-4" action="/interprets/edit" method="post">
          <input type="hidden" class="form-control" name="id_interpret" value="<?php echo $id;
//id interpreta
?>" required>
          <div class="form-group row">
            <label class="col-2 col-form-label">Jméno</label>
            <div class="col-10">
              <input type="text" class="form-control" name="name_interpret" value="<?php echo $interpret[
                  "name_interpret"
              ];
//název interpreta
?>" required>
            </div>
          </div>
          <button type="submit" class="btn btn-primary ml-auto mt-3 mr-2" >Aktualizovat</button>
            <a class="btn btn-primary ml-2 mr-auto mt-3" href="/interprets">Zpět</a>
        </form>
      </div>
    </div>
  </div>
</div>