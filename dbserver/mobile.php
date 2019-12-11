<?php

    if ($_GET != null) {
        if($_GET['action'] != null) $action = $_GET['action'];
        if($_GET['dbname'] != null) $dbname = $_GET['dbname'];
        if($_GET['tablename'] != null) $tablename = $_GET['tablename'];
    } else {
        if($_POST['action'] != null) $action = $_POST['action'];
        if($_POST['dbname'] != null) $dbname = $_POST['dbname'];
        if($_POST['tablename'] != null) $tablename = $_POST['tablename'];
    }

    if ($action == 'listdatabases') {
        require_once("mobile/listdatabases.php");
    }

    if ($action == 'createdatabase') {
        if ($dbname != null) {
            require_once("mobile/createdatabase.php");
            echo "Create Database `".$dbname."` succeful!";
        } else {
            echo "Database name not found!<br>";
        }
    }

    if ($action == 'deletedatabase') {
        if ($dbname != null)
            require_once("mobile/deletedatabase.php");
        else
            echo "Database name not found!<br>";
    }

    if ($action == 'listtables') {
        if ($dbname != null)
            require_once("mobile/listtables.php");
        else
            echo "Database name not found!<br>";
    }

    if ($action == 'describetable') {
        if (($dbname != null) && ($tablename != null))
            require_once("mobile/describetable.php");
        else
            echo "Database/Table name not found!<br>";
    }

    if ($action == 'createtable') {
        if (($dbname != null) && ($tablename != null))
            require_once("mobile/createtable.php");
        else
            echo "Database/Table name not found!<br>";
    }

    if ($action == 'deletetable') {
        if (($dbname != null) && ($tablename != null))
            require_once("mobile/deletetable.php");
        else
            echo "Database/Table name not found!<br>";
    }

    if ($action == 'querydata') {
        if (($dbname != null) && ($tablename != null))
            require_once("mobile/querydata.php");
        else
            echo "Query data error!<br>";
    }


/*
    if ($action == 'modifytable') {
        if (($dbname != null) && ($tablename != null))
        else
            echo "Database/Table name not found!<br>";
    }

    if ($action == 'insertdata') {
        if (($dbname != null) && ($tablename != null))
        else
            echo "Database/Table name not found!<br>";
    }

    if ($action == 'modifydata') {
        if (($dbname != null) && ($tablename != null))
        else
            echo "Database/Table name not found!<br>";
    }

    if ($action == 'deletedata') {
        if (($dbname != null) && ($tablename != null))
        else
            echo "Database/Table name not found!<br>";
    }
*/
?>
