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

//počet řádků které dotaz vrátil https://stackoverflow.com/questions/48935729/how-to-count-records-in-query-result-on-sqlite3-using-php
function countRows($result) {
  $count = 0;
  $result->reset();
  while ($result->fetchArray())
    $count++;
  $result->reset();
  return $count;
}
?>