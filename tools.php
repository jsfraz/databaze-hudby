<?php
function querySql($sql) {
  //$conn = getMysql();
  $db = new SQLite3(__DIR__ . "/database.db");
  return $db->query($sql);
}

function hasRows($result) {
  $rows = 0;
  while ($result->fetchArray() && $rows == 0) {
    $rows++;
  }
  return $rows > 0;
}
?>