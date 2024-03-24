<?php

if($_SERVER['SERVER_NAME'] == 'localhost'){
    define('DBUSER', "76297597");
    define("DBPASS", "76297597");
    define("DBNAME", "db_76297597");
    define("DBHOST", "localhost");
}else{
    define('DBUSER', "root");
    define('DBPASS', "");
    define('DBNAME', "myblogpost");
    define('DBHOST', "localhost");
}


?>
