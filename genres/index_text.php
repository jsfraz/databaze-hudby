<?php
//nástroje
require_once $_SERVER["DOCUMENT_ROOT"] . "/tools.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (
        preg_match(
            "/^\/genres(.{0}|\?order=(id_genre|name_genre)&mode=(asc|desc))$/",
            $_SERVER["REQUEST_URI"]
        ) == false
    ) {
        $errorTitle = "Chyba";
        $errorText = "Neplatný požadavek.";
        include $_SERVER["DOCUMENT_ROOT"] . "/error.php";
    }

    $order = "id_genre";
    $orderMode = "asc";
    //order
    if (empty($_GET["order"]) == false) {
        $order = $_GET["order"];
        setCustomCookie("genres_order", $order);
    } else {
        if (empty($_COOKIE["genres_order"]) == false) {
            if (
                preg_match(
                    "/^(id_genre|name_genre)$/",
                    $_COOKIE["genres_order"]
                )
            ) {
                $order = $_COOKIE["genres_order"];
            }
            setCustomCookie("genres_order", $order);
        }
    }
    //mode
    if (empty($_GET["mode"]) == false) {
        $orderMode = $_GET["mode"];
        setCustomCookie("genres_order_mode", $orderMode);
    } else {
        if (empty($_COOKIE["genres_order_mode"]) == false) {
            if (preg_match("/^(asc|desc)$/", $_COOKIE["genres_order_mode"])) {
                $orderMode = $_COOKIE["genres_order_mode"];
            }
            setCustomCookie("genres_order_mode", $orderMode);
        }
    }
}

function getOrderSelected($column, $order)
{
    if ($order == $column) {
        echo "selected";
    }
}

function getModeSelected($column, $orderMode)
{
    if ($orderMode == $column) {
        echo "selected";
    }
}
?>

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
        <div class="col-md-12 text-left">
          <!-- collapse výběru řazení https://getbootstrap.com/docs/4.0/components/collapse/ --->
          <a onclick="filterClick('genres_filter_collapse')" data-toggle="collapse" href="#collapse" role="button" aria-expanded="false" aria-controls="collapse">Filtry</a>
          <?php
          $showFilter = "";
          if ($_COOKIE["genres_filter_collapse"] == "false") {
              $showFilter = "show";
          }
          ?>
          <div class="collapse <?php echo $showFilter; ?>" id="collapse">
            <form method="get" draggable="true">
              <label class="col-form-label text-light">Řadit podle</label>
              <select name="order" class="form-control form-control-sm w-25" draggable="true" required>
                <option value="id_genre" <?php getOrderSelected(
                    "id_genre",
                    $order
                ); ?>>ID žánru</option>
                <option value="name_genre" <?php getOrderSelected(
                    "name_genre",
                    $order
                ); ?>>Název žánru</option>
              </select>
              <label class="col-form-label">Režim</label>
              <select name="mode" class="form-control form-control-sm w-25" required>
                <option value="asc" <?php getModeSelected(
                    "asc",
                    $orderMode
                ); ?>>Vzestupně</option>
                <option value="desc" <?php getModeSelected(
                    "desc",
                    $orderMode
                ); ?>>Sestupně</option>
              </select>
              <input type="submit" value="Řadit" class="btn btn-primary mt-2">
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="list-group mt-4">
              <?php
              //dotaz na všechny skladby
              $result = querySql(
                  "SELECT id_genre, name_genre FROM genres ORDER BY " .
                      $order .
                      " " .
                      $orderMode .
                      ";"
              );

              //kontrola počtu řádků
              if (countRows($result) > 0) {
                  //jeden a více výsledků

                  //hlavička tabulky
                  echo '<div class="list-group-item  text-center text-uppercase">
              <div class="row">
                <div class="col-md-11">
                  <h4>Název</h4>
                </div>
                <div class="col-md-1">
                  <a href="/genres/insert"><i class="fa fa-2x fa-plus text-light"></i></a>
                </div>
              </div>
              </div>';
                  //vypsání skladeb
                  while ($row = $result->fetchArray()) {

                      echo '<div class="list-group-item text-center">
                <div class="row">
                <div class="col-md-11">
                  <h5>' .
                          $row["name_genre"] .
                          '</h5>
                </div>' .
                          '<div class="col-md-1">
                  <div class="row">
                    <div class="col-md-6">
                      <a href="/genres/edit?id_genre=' .
                          $row["id_genre"] .
                          '"><i class="fa fa-2x fa-pencil text-light"></i></a>
                    </div>
                    <div class="col-md-6">
                      <form action="/genres/delete" method="post">
                         <input type="hidden" required="required" name="id_genre" value="' .
                          $row["id_genre"] .
                          '">
                        <button class="transparent-btn" type="submit"><i class="fa fa-2x fa-trash text-danger"></i></button>
                      </form>
                    </div>
                  </div>
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