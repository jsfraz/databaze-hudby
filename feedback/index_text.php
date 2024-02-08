<?php
if (
    $_SERVER["REQUEST_URI"] != "/feedback" ||
    $_SERVER["REQUEST_METHOD"] != "POST"
) {
    exit();
}

$path = "/";

$email = $_POST["email"];
$message = $_POST["message"];
$path = $_POST["path"];

//validace
//TODO validace cesty
if (filter_var($email, FILTER_VALIDATE_EMAIL) && empty($message) == false) {
    //TODO odeslání feedbacku mailem
    $title = "Děkujeme!";
    $text = "Vážíme si vaší zpětné vazby.";
} else {
    $title = "Chyba!";
    $text = "Váš e-mail není správný nebo jste odeslali prázdnou zprávu.";
}
?>
<div class="py-5 section-fade-in h-100" style="background-image: url(images/nirvana.jpg);	background-position: center;	background-size: cover;	background-repeat: no-repeat;">
  <div class="container p-4 my-5">
    <div class="row">
      <div class="col-12">
        <h1 class="mb-3"><?php echo $title; ?></h1>
        <h2><?php echo $text; ?></h2>
      </div>
      <div class="col-12">
        <a class="btn btn-outline-primary" href="<?php echo $path; ?>">Zpět</a>
      </div>
    </div>
  </div>
</div>