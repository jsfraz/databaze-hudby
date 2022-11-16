<?php
//mysql připojení
function getMysqlConnection() {
  return mysqli_connect(
    getenv("servername"),
    getenv("username"),
    getenv("password"),
    getenv("dbname"));
}

//sqlite "připojení"
function getSqliteConnection() {
  return new SQLite3(__DIR__ . "/" . getenv("sqlite_file"));
}

//vykoná dotaz
function querySql($sql) {
  $useMysql = false;    //mysql nebo sqlite
  $db = null;
  if ($useMysql) {
    $db = getMysqlConnection();
  } else {
    $db = getSqliteConnection();
  }
  return $db->query($sql);
}

//počet řádků https://stackoverflow.com/questions/48935729/how-to-count-records-in-query-result-on-sqlite3-using-php
function countRows($result) {
  $nrows = 0;
  $result->reset();
  while ($result->fetchArray())
    $nrows++;
  $result->reset();
  return $nrows;
}
?>