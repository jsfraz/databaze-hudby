<?php
//vytvoření připojení
function getMysqlConnection() {
  return mysqli_connect(
    getenv("servername"),
    getenv("username"),
    getenv("password"),
    getenv("dbname"));
}

function querySql($sql) {
  $conn = getMysqlConnection();
  //kontrola připojení
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }
  return $conn->query($sql);
}
?>