<?php
//mysql připojení
function getMysqlConnection()
{
    return mysqli_connect(
        getenv("servername"),
        getenv("username"),
        getenv("password"),
        getenv("dbname")
    );
}

//sqlite "připojení" ze souboru
function getSqliteConnection()
{
    return new SQLite3($_SERVER["DOCUMENT_ROOT"] . "/" . getenv("sqlite_file"));
}

//vykoná dotaz a vrátí pole řádků
function querySql($sql)
{
    //použití mysql nebo sqlite
    $db = getSqliteConnection();
    //výsledek
    return $db->query($sql);
}

//vykoná dotaz a vrátí jeden výsledek
function querySqlSingle($sql)
{
    //použití mysql nebo sqlite{
    $db = getSqliteConnection();
    //výsledek
    return $db->querySingle($sql);
}

//vykoná bezdotazový příkaz
function querySqlExec($sql)
{
    //použití mysql nebo sqlite{
    $db = getSqliteConnection();
    //výsledek
    return $db->exec($sql);
}

//vykoná bezdotazový příkaz
function querySqlExecCustom($db, $sql)
{
    //výsledek
    return $db->exec($sql);
}

//počet řádků které dotaz vrátil https://stackoverflow.com/questions/48935729/how-to-count-records-in-query-result-on-sqlite3-using-php
function countRows($result)
{
    $count = 0;
    $result->reset();
    while ($result->fetchArray()) {
        $count++;
    }
    $result->reset();
    return $count;
}

//unix čas na human readable https://stackoverflow.com/questions/13477788/convert-epoch-time-to-date-php/13477883#13477883
function convertEpochTime($epoch)
{
    $datetime = new DateTime("@$epoch");
    $text = $datetime->format("d.m. Y");
    return $text;
}

//unix čas pro html input
function convertEpochTimeInput($epoch)
{
    $datetime = new DateTime("@$epoch");
    $text = $datetime->format("Y-m-d");
    return $text;
}

//postnuté datum z formuláře na unix čas
//https://www.geeksforgeeks.org/php-datetime-createfromformat-function/
//https://www.php.net/manual/en/datetime.gettimestamp.php
function convertYmdToEpochTime($input)
{
    $datetime = DateTime::createFromFormat("Y-m-d", $input);
    $epoch = $datetime->getTimestamp();
    return $epoch;
}

/*
//validace unix času
//https://stackoverflow.com/questions/10724034/how-to-validate-unix-time-with-regexp-on-php
function isUnixTime($t) {
  if (is_numeric($t) && 0<$t && $t<strtotime("2038")) {
    return true;
  } else {
    return false;
  }
}
*/

//validace data z Y-m-d formátu
//https://stackoverflow.com/questions/11029769/function-to-check-if-a-string-is-a-date
function isValidYmd($input)
{
    if (DateTime::createFromFormat("Y-m-d", $input) !== false) {
        return true;
    } else {
        return false;
    }
}

function setCustomCookie($name, $value)
{
    //https://stackoverflow.com/questions/58191969/how-to-fix-set-samesite-cookie-to-none-warning
    $cookieOptions = [
        "expires" => time() + (365*24 * 60 * 60),
        "path" => "/",
        "secure" => true,
        "httponly" => false,
        "samesite" => "None",
    ];
    setcookie($name, $value, $cookieOptions);
}
?>
