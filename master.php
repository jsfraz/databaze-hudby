<!DOCTYPE html>
<html>
  <head>
    <!-- master šablona podle https://stackoverflow.com/questions/8249220/masterpage-in-php -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <title>Databáze hudby</title>
    <link rel="stylesheet" href="neon.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  </head>
  <body class="text-center">
    <!-- začátek headeru-->
    <nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark" >
    <div class="container">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar2SupportedContent" aria-controls="navbar2SupportedContent" aria-expanded="false" aria-label="Toggle navigation" style=""> <span class="navbar-toggler-icon"></span> </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbar2SupportedContent">
        <ul class="navbar-nav">
          <li class="nav-item mx-2">
            <a class="nav-link" href="/">Domů</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link" href="/songs">Skladby</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link" href="/">Alba</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link" href="/">Žánry</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link" href="/">Interpreti</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
    <!-- konec headeru-->

    <!-- stránka-->
    <?php include($content); ?>

    <!-- začátek footeru-->
    <footer class="text-md-left text-center p-4">
    <div class="container">
      <div class="row">
        <div class="my-3 col-lg-4 col-md-4">
          <h3>Zpětná vazba</h3>
          <form action="/feedback.php" method="post">
            <fieldset class="form-group my-3">
              <input type="email" class="form-control" name="email" placeholder="Email" required> </fieldset>
            <fieldset class="form-group my-3">
              <input type="text" class="form-control" name="message" placeholder="Zpráva" required> </fieldset>
            <!-- skrytá proměnná https://stackoverflow.com/questions/34253825/how-to-send-hidden-php-variable-with-html-form/34254076#34254076 --->
            <input type="hidden" name="path" value="<?php echo $_SERVER["REQUEST_URI"] ?>" required>
            <button type="submit" class="btn btn-outline-primary">Odeslat</button>
          </form>
        </div>
        <div class="col-lg-4"> </div>
        <div class="my-3 col-lg-4">
          <h3>Odkazy</h3>
          <a href="https://github.com/jsfraz/databaze-hudby"><i class="fa text-muted fa-3x m-2 fa-github" ></i></a>
          <a href="https://replit.com/@jsfrz/databaze-hudby"><i class="fa fa-3x text-muted m-2 fa-code"></i></a>
        </div>
      </div>
    </div>
  </footer>
    <!-- konec footeru-->
  </body>
</html>
