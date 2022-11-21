<?php
if ($_SERVER["REQUEST_URI"] == "/songs") {
    //pohoda
} else {
    echo "Chyba v Matrixu"; //TODO forbidden stránka
    exit();
} ?>

<!-- duhové pozadí https://stackoverflow.com/questions/56418763/creating-the-perfect-rainbow-gradient-in-css/63302468#63302468 --->
<div class="align-items-center cover py-5" style="	background-image: linear-gradient(
        to bottom,
        rgba(255, 0, 0, 0.1) 0%,
        rgba(255, 154, 0, 0.1) 10%,
        rgba(208, 222, 33, 0.1) 20%,
        rgba(79, 220, 74, 0.1) 30%,
        rgba(63, 218, 216, 0.1) 40%,
        rgba(47, 201, 226, 0.1) 50%,
        rgba(28, 127, 238, 0.1) 60%,
        rgba(95, 21, 242, 0.1) 70%,
        rgba(186, 12, 248, 0.1) 80%,
        rgba(251, 7, 217, 0.1) 90%,
        rgba(255, 0, 0, 0.1) 100%
    );	background-position: top left;	background-size: 100%;	background-repeat: repeat;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="list-group">
              <?php
              //nástroje
              require_once "../tools.php";

              //dotaz na všechny skladby
              $result = querySql(
                  "SELECT id_song, name_song, name_album, name_interpret FROM songs INNER JOIN albums ON songs.id_album = albums.id_album INNER JOIN interprets ON songs.id_interpret = interprets.id_interpret;"
              );

              //kontrola počtu řádků
              if (countRows($result) > 0) {
                  //jeden a více výsledků

                  //hlavička tabulky
                  echo '<div class="list-group-item text-center text-uppercase">
              <div class="row">
                <div class="col-md-4">
                  <h4>Název</h4>
                </div>
                <div class="col-md-4">
                  <h4>Album</h4>
                </div>
                <div class="col-md-3">
                  <h4>Interpret</h4>
                </div>
                <div class="col-md-1">
                </div>
              </div>
              </div>';
                  //vypsání skladeb
                  while ($row = $result->fetchArray()) {
                      echo '<div class="list-group-item text-center">
                <div class="row">
                <div class="col-md-4">
                  <h5>' .
                          $row["name_song"] .
                          '</h5>
                </div>
                <a class="col-md-4" href="/">
                  <h5>' .
                          $row["name_album"] .
                          '</h5>
                </a>
                <a class="col-md-3" href="/">
                  <h5>' .
                          $row["name_interpret"] .
                          '</h5>
                </a>
                <div class="col-md-1">
                </div>
              </div>
            </div>';
                  }
              } else {
                  //nula výsledků
                  echo '
<div class="py-5 text-center text-white h-100 align-items-center d-flex">
    <div class="container py-5">
      <div class="row">
        <div class="mx-auto col-lg-8 col-md-10">
          <h3 class="display-4">Nebyly nalezeny žádé výsledky.</h3>
        </div>
      </div>
    </div>
  </div>
';
              }
              ?>
        
          </div>
        </div>
      </div>
    </div>
  </div>