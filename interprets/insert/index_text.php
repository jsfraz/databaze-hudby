<?php
if ($_SERVER["REQUEST_URI"] != "/interprets/insert") {
    exit();
}

//nástroje
require_once $_SERVER["DOCUMENT_ROOT"] . "/tools.php";

//POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //atributy
    $name = $_POST["name_interpret"];

    //validace
    if (preg_match('#^[^"\']+$#', $name)) {
        //vložení
        $db = getSqliteConnection();
        $success = querySqlExecCustom(
            $db,
            "INSERT INTO interprets (name_interpret) VALUES ('" . $name . "');"
        );

        if ($success) {
            //id posledního vloženého řádku: https://stackoverflow.com/questions/8892973/how-to-get-last-insert-id-in-sqlite
            $id = $db->lastInsertRowId();
            header("Location: /interprets/edit?id_interpret=" . $id);
        } else {
            $errorTitle = "Chyba";
            $errorText = "Nepodařilo se přidat interpreta.";
            include $_SERVER["DOCUMENT_ROOT"] . "/error.php";
        }
    } else {
        $errorTitle = "Chyba";
        $errorText = "Neplatný požadavek.";
        include $_SERVER["DOCUMENT_ROOT"] . "/error.php";
    }
    exit();
}
?>

<div class="py-5 section-fade-in h-100" style="background-image: url(/images/nirvana.jpg);	background-position: center;	background-size: cover;	background-repeat: no-repeat;">
  <div class="container">
    <div class="row mx-auto">
      <div class="col-md-12">
        <form class="w-75 mx-auto mt-4" action="/interprets/insert" method="post">
          <div class="form-group row">
            <label class="col-2 col-form-label">Jméno</label>
            <div class="col-10">
              <input type="text" class="form-control" name="name_interpret" required>
            </div>
          </div>
          <button type="submit" class="btn btn-primary ml-auto mt-3 mr-2" >Přidat</button>
            <a class="btn btn-primary ml-2 mr-auto mt-3" href="/interprets">Zpět</a>
        </form>
      </div>
    </div>
  </div>
</div>