<html>
  <head>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <title>Databáze hudby</title>
    <!-- master šablona https://stackoverflow.com/questions/8249220/masterpage-in-php -->
  </head>
  <body>
    <!-- začátek headeru-->
    <div id="menu">
      <a href="/">Home</a>
      <a href="/songs">Songs</a>
    </div>
    <br>
    <!-- konec headeru-->

    <!-- stránka-->
    <div> <?php include($content); ?> </div>

    <!-- začátek footeru-->
    <br>
    <div id="footer">FOOTER</div>
    <!-- konec footeru-->
  </body>
</html>
