<?php
if (empty($errorTitle) && empty($errorText)) {
  exit();
}
?>

<div class="py-5 section-fade-in h-100" style="background-image: url(/images/nirvana.jpg);	background-position: center;	background-size: cover;	background-repeat: no-repeat;">
  <div class="container p-4 my-5">
    <div class="row">
      <div class="col-12">
        <h1 class="mb-3"><?php echo $errorTitle; ?></h1>
        <h2><?php echo $errorText; ?></h2>
      </div>
      <div class="col-12">
        <a class="btn btn-outline-primary" href="/">Domů</a>
      </div>
    </div>
  </div>
</div>

<?php exit(); ?>