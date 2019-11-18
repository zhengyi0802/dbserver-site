<?php

    if ($_GET != null) {
        if($_GET['action'] != null) $action = $_GET['action'];
        if($_GET['dbname'] != null) $dbname = $_GET['dbname'];
    } else {
        if($_POST['action'] != null) $action = $_POST['action'];
        if($_POST['dbname'] != null) $dbname = $_POST['dbname'];
    }

    if ($action == 'listdatabases') {
        require_once("mobile/listdatabases.php");
    }

    if ($action == 'createdatabase') {
        require_once("mobile/createdatabase.php");
    }


?>
