<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $message = $_POST["message"];
  $path = $_POST["path"];
  //TODO odeslání feedbacku mailem
  header("Location: " . $path);
}
?>