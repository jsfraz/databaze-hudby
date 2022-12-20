<!DOCTYPE html>
<html>
  <head>
    <!-- master šablona podle https://stackoverflow.com/questions/8249220/masterpage-in-php -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <title>Databáze hudby</title>
    <link rel="stylesheet" href="/css/cookiealert.css">
    <link rel="stylesheet" href="/css/custom.css">
    <link rel="stylesheet" href="/css/neon.css">
    <script src="/js/navbar-ontop.js"></script>
    <script src="/js/animate-in.js"></script>
    <script src="/js/jquery-3.3.1.min.js"></script>
    <script src="/js/popper-1.14.3.min.js"></script>
    <script src="/js/bootstrap-4.1.3.min.js"></script>
    <script type="text/javascript" src="/js/cookies.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  </head>
  <body class="text-center">
    <!-- začátek headeru-->
    <nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark">
      <div class="container">
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar2SupportedContent" aria-controls="navbar2SupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbar2SupportedContent">
          <ul class="navbar-nav">
            <li class="nav-item mx-2">
              <a class="nav-link" href="/">Domů</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link" href="/songs">Skladby</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link" href="/albums">Alba</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link" href="/genres">Žánry</a>
            </li>
            <li class="nav-item mx-2">
              <a class="nav-link" href="/interprets">Interpreti</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- konec headeru-->

    <?php if ($_SERVER["REQUEST_URI"] == "/master.php") {
      $errorTitle = "Chyba";
      $errorText = "Neplatný požadavek.";
      include $_SERVER["DOCUMENT_ROOT"] . "/error.php";
    } ?>
    
    <!-- stránka-->
    <?php include $content; ?>

    <!-- začátek footeru-->
    <footer class="text-md-left text-center p-4">
      <div class="container">
        <div class="row">
          <div class="my-3 col-lg-4 col-md-4">
            <h3>Zpětná vazba</h3>
            <form action="/feedback" method="post">
              <fieldset class="form-group my-3">
                <input type="email" class="form-control" name="email" placeholder="Email" required>
              </fieldset>
              <fieldset class="form-group my-3">
                <input type="text" class="form-control" name="message" placeholder="Zpráva" required>
              </fieldset>
              <!-- skrytá proměnná https://stackoverflow.com/questions/34253825/how-to-send-hidden-php-variable-with-html-form/34254076#34254076 --->
              <input type="hidden" name="path" value="<?php echo $_SERVER[
                  "REQUEST_URI"
              ]; ?>" required>
              <button type="submit" class="btn btn-outline-primary">Odeslat</button>
            </form>
          </div>
          <div class="col-lg-4"></div>
          <div class="my-3 col-lg-4">
            <h3>Odkazy</h3>
            <a href="https://github.com/jsfraz/databaze-hudby">
              <i class="fa text-muted fa-3x m-2 fa-github"></i>
            </a>
            <a href="https://replit.com/@jsfrz/databaze-hudby">
              <i class="fa fa-3x text-muted m-2 fa-code"></i>
            </a>
          </div>
        </div>
      </div>
    </footer>
    <!-- konec footeru-->
    
    <!-- START Bootstrap-Cookie-Alert -->
    <div class="alert text-center cookiealert bg-dark fixed-bottom" role="alert">
      <b>Máte rádi sušenky?</b> &#x1F36A; Používáme cookies, abychom vám zajistili co nejlepší zážitek z našich webových stránek. <a href="https://www.cookie-lista.cz/co-je-cookies.html" target="_blank">Dozvědět se více</a>
      <button type="button" class="btn btn-primary btn-sm acceptcookies">Souhlasím</button>
    </div>
    <!-- END Bootstrap-Cookie-Alert -->
    
    <!-- Bootstrap-Cookie-Alert skript -->
    <script src="/js/cookiealert.js"></script>
  </body>
</html>