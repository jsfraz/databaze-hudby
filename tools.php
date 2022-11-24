<?php
//mysql připojení
function getMysqlConnection() {
  return mysqli_connect(
    getenv("servername"),
    getenv("username"),
    getenv("password"),
    getenv("dbname"));
}

//sqlite "připojení" ze souboru
function getSqliteConnection() {
  return new SQLite3($_SERVER['DOCUMENT_ROOT'] . "/" . getenv("sqlite_file"));
}

//vykoná dotaz a vrátí pole řádků
function querySql($sql) {
  //použití mysql nebo sqlite
  $db = getSqliteConnection();
  //výsledek
  return $db->query($sql);
}

//vykoná dotaz a vrátí jeden výsledek
function querySqlSingle($sql) {
  //použití mysql nebo sqlite{
  $db = getSqliteConnection();
  //výsledek
  return $db->querySingle($sql);
}

//vykoná bezdotazový příkaz
function querySqlExec($sql) {
  //použití mysql nebo sqlite{
  $db = getSqliteConnection();
  //výsledek
  return $db->exec($sql);
}

//počet řádků které dotaz vrátil https://stackoverflow.com/questions/48935729/how-to-count-records-in-query-result-on-sqlite3-using-php
function countRows($result) {
  $count = 0;
  $result->reset();
  while ($result->fetchArray())
    $count++;
  $result->reset();
  return $count;
}

//unix čas na human readable https://stackoverflow.com/questions/13477788/convert-epoch-time-to-date-php/13477883#13477883
function convertEpochTime($epoch) {
  $datetime = new DateTime("@$epoch");
  $text = $datetime->format("d.m. Y");
  return $text;
}

//unix čas pro html input
function convertEpochTimeInput($epoch) {
  $datetime = new DateTime("@$epoch");
  $text = $datetime->format("Y-m-d");
  return $text;
}

//postnuté datum z formuláře na unix čas
//https://www.geeksforgeeks.org/php-datetime-createfromformat-function/
//https://www.php.net/manual/en/datetime.gettimestamp.php
function convertYmdToEpochTime($input) {
  $datetime = DateTime::createFromFormat("Y-m-d", $input);
  $epoch = $datetime->getTimestamp();
  return $epoch;
}
?>