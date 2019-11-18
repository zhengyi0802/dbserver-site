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

    echo "Drop Database 'test2'<br>";
    $dbo->drop_db($dbname2);
    echo "Ok<br>";

    echo "Use Database 'test'<br>";
    $dbo->use_db($dbname);
    echo "Ok<br>";

    echo "List tables of Database 'test'<br>";
    $res = $dbo->list_tables();
    foreach ($res as $tbl) {
       echo $tbl[0]."<br>";
    }
    echo "Ok<br>";

    echo "delete table 'test2'<br>";
    $res = $dbo->drop_table('test2', true);
    echo "Ok<br>";

    echo "insert table 'test2'<br>";
    $struct[0]['name'] = "name";
    $struct[0]['type'] = "varchar(30)";
    $struct[0]['notnull'] = true;
    $struct[0]['default'] = null;
    $struct[1]['name'] = "createdate";
    $struct[1]['type'] = "datetime";
    $struct[1]['notnull'] = true;
    $struct[1]['default'] = null;
    $struct[2]['name'] = "jsondata";
    $struct[2]['type'] = "json";
    $struct[2]['notnull'] = false;
    $struct[2]['default'] = null;
    $res = $dbo->create_table('test2', $struct);
    echo "Ok<br>";
    echo "alter table 'test2' for add column 'memo' <br>\n";
    $struct=null;
    $struct[0]['name'] = "id";
    $struct[0]['type'] = "varchar(20)";
    $struct[0]['notnull'] = true;
    $struct[0]['default'] = null;
    $struct[0]['position'] = "jsondata";
    $res = $dbo->add_column('test2', $struct);
    echo "Ok<br>";

    echo "insert data to 'test2' <br>";
    $data = null;
    $data[0]['key'] = 'name';
    $data[0]['val'] = 'testforme';
    $data[1]['key'] = 'createdate';
    $data[1]['val'] = "CURRENT_TIME";
    $data[2]['key'] = 'jsondata';
    $data[2]['val'] = null;
    $data[3]['key'] = "id";
    $data[3]['val'] = "m2213442";
    //$data[4]['key'] = "memo";
    //$data[4]['val'] = null;
    $res = $dbo->insert_data("test2", $data);
    echo "Ok<br>";

    echo "query data from 'test2' <br>";
    $sql = "SELECT * FROM `test2` WHERE 1;<br>";
    $res = $dbo->query_data($sql);
    foreach($res as $data) {
        foreach($data as $key => $val) {
            echo $key."=".$val."<br>";
        }
    }
    echo "Ok<br>";

    echo "delete a record from 'test2' <br>";
    $cond = "`id` = 1";
    $res = $dbo->delete_data("test2", $cond, false);
    echo "Ok<br>";

    echo "modify a record from 'test2' <br>";
    $data = null;
    $data[0]['key'] = 'name';
    $data[0]['val'] = 'dddddddd';
    $data[1]['key'] = 'id';
    $data[1]['val'] = 'm2222222';
    $cond = "`id` = 1";
    $res = $dbo->modify_data("test2", $data, $cond);
    echo "Ok<br>";
?>
