<!DOCTYPE html>
<html>
  <head>
    <!-- master šablona podle https://stackoverflow.com/questions/8249220/masterpage-in-php -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <title>Databáze hudby</title>
    <link rel="stylesheet" href="neon.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  </head>
  <?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $email = $_POST["email"];
      $message = $_POST["message"];
      $path = $_POST["path"];

      $title = "";
      $text = "";

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
  } else {
      exit();
  } ?>
  <body class="text-center">
    <div class="py-5 section-fade-in h-100" style="	background-image: url(images/index/nirvana.jpg);	background-position: top left;	background-size: 100%;	background-repeat: repeat;">
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
  </body>
</html>