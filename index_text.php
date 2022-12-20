<?php
if ($_SERVER["REQUEST_URI"] != "/") {
    $errorTitle = "Chyba";
    $errorText = "Neplatný požadavek.";
    include $_SERVER["DOCUMENT_ROOT"] . "/error.php";
} ?>

<?php
$x = rand(1, 25);
echo '<div class="d-flex align-items-center py-5 cover section-fade-in-out" style="background-image: url(images/index/' .
    $x .
    '.jpg);">';
?>
  <div class="container">
    <div class="row">
      <div class="col-12 mt-5">
        <h1 class="display-4">Databáze hudby</h1>
        <p class="lead">Skladby, alba, interpreti...</p>
      </div>
    </div>
  </div>
</div>
<div class="py-5 section-fade-in" style="background-image: url(images/nirvana.jpg);	background-position: center;	background-size: cover;	background-repeat: no-repeat;">
  <div class="container p-4 my-5">
    <div class="row">
      <div class="col-12">
        <h1 class="mb-3">O nás</h1>
        <h2>Zde najdete seznam hudebních skladeb, alb, žánrů a interpretů. <br>Jedná se o malý projekt, jehož cílem je shromažďovat informace o tom co nás baví, a to je hudba. </h2>
      </div>
    </div>
  </div>
</div>