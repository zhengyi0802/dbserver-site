<?php
    require_once "db_config.php";
    require_once "mysql.lib.php";

    echo "connect databases<br>";
    echo "host = " . $host . "<br>";
    echo "user = " . $user . "<br>";
    echo "pass = " . $pass . "<br>";
    $DAO = new mysqlobj($host, $user, $pass);

    echo "<br>";
    echo "create database test2<br>";
    $DAO->create_database("test2");

    echo "list databases<br>";
    $result = $DAO->list_databases();

    if (!$result) echo "no database<br>";
    else echo "databases list are as follows: <br>";

    foreach ($result as $dbname) {
        echo $dbname . "<br>";
    }


    echo "delete database test2<br>";
    $DAO->drop_database("test2");


    echo "use database test<br>";
    $DAO->use_database("test");

    echo "list tables of database test<br>";
    $result = $DAO->list_tables();
    foreach ($result as $tablename) {
        echo $tablename . "<br>";
    }

    

?>
