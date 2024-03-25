<?php

if($_SERVER['SERVER_NAME'] == 'localhost'){
    if(!defined('DBUSER')) define('DBUSER', "root");
    if(!defined('DBPASS')) define("DBPASS", "");
    if(!defined('DBNAME')) define("DBNAME", "myblogpost");
    if(!defined('DBHOST')) define("DBHOST", "localhost");
}else{
    if(!defined('DBUSER')) define('DBUSER', "76297597");
    if(!defined('DBPASS')) define("DBPASS", "76297597");
    if(!defined('DBNAME')) define("DBNAME", "db_76297597");
    if(!defined('DBHOST')) define("DBHOST", "localhost");
}

?>