<?php
    require_once("db_config.php");
    require_once("dbclass.lib.php");

    echo "Login Server<br>";
    echo "host = ".$host."<br>";
    echo "port = ".$port."<br>";
    echo "user = ".$user."<br>";
    echo "pass = ".$pass."<br>";
    echo "dbname=".$dbname."<br>";

    $dbo = new dbclass($host, null, $user, $pass, null);
    echo "Ok <br>";

    echo "List Databases<br>";
    $res = $dbo->list_databases();
    foreach ($res as $dbn) {
       echo $dbn."<br>";
    }

    echo "Use Database 'test'<br>";
    $dbo->use_db($dbname);
    echo "Ok<br>";

    echo "Create Database 'test2'<br>";
    $dbname2 = "test2";
    $dbo->create_db($dbname2);
    echo "Ok<br>";


?>
