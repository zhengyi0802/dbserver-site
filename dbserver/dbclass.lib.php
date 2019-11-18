<?php

    class dbclass {

      private $host = "";
      private $port = "";
      private $user = "";
      private $pass = "";
      private $dbname = "";
      private $dsn  = "";
      private $conn = null;
      private $debug = true;

      public function __construct($host, $port = null, $user, $pass, $dbname = null) {
        $this->host = $host;
        $this->user = $user;
        $this->port = $port;
        $this->pass = $pass;
        $this->dbname = $dbname;

        $dsn = "mysql:".$host;
        if ($port) {
           $dsn .= ":" . $port;
        }
        if ($dbname) {
            $dsn .= ";dbame=" . $dbname;
        }

        echo $dsn."<br>";

        try {
          $this->conn = new PDO($dsn, $user, $pass);
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
          //$conn = null;
          die("DB ERROR: ".$e->getMessage());
        }

      } // end of function __construct

      public function __destruct() {
        $conn = null;
      } // end of function __destruct

      public function getPDO() {
        return $conn;
      } // end of function getPDO

      public function create_db($dbname) {
        $this->dbname = $dbname;
        try {
          $sql = "CREATE DATABASE " . $this->dbname;
          $resulr = $this->conn->exec($sql);
        } catch (PDOException $e) {
          die("DB ERROR: ".$e->getMessage());
        }

      } // end of function create_db

      public function use_db($dbname) {
        $this->dbname = $dbname;
        echo "dbname = ".$this->dbname."<br>";
        try {
          $sql = "USE " . $this->dbname;

          $result = $this->conn->exec($sql);
        } catch (PDOException $e) {
          die("DB ERROR: ".$e->getMessage());
        }
      } // end of function use_db

      public function drop_db($dbname) {
        $sql = "DROP DATABASE ".$dbname;
        try {
          $result = $this->conn->exec($sql);
        } catch (PDOException $e) {
          die("DB ERROR: ".$e->getMessage());
        }
      } // end of function drop_db

      public function list_databases() {
        $sql = "SHOW DATABASES";
        try {
          if ($this->conn == null) {
              echo "conn is null<br>";
          }
          //$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
          $result = $this->conn->query($sql);
          $dbs = array();
          foreach($result as $row) {
             if ($debug) echo $row['Database']."<br>";
             array_push($dbs, $row['Database']);
          }
          return $dbs;
        } catch (PDOException $e) {
          die("DB ERROR: ".$e->getMessage());
        }
      } // end of function list_databases

      public function getDBname() {
        return $this->dbname;
      } // end of function getDBname
/*
      public function create_table($tablename, $json) {
        try {
        } catch (PDOException $e) {
          die("DB ERROR: ".$e->getMessage());
        }
      } // end of function create_table

      public function modify_table($tablename, $json, $flag = false) {
        if ($flag) {
            try {
            } catch (PDOException $e) {
              die("DB ERROR: ".$e->getMessage());
            }
        }
      } // end of function modify_table

      public function delete_table($tablename, $flag = false) {
        if ($flag) {
            try {

            } catch (PDOException $e) {
              die("DB ERROR: ".$e->getMessage());
            }
        }
      } // end of function delete_table

      public function list_tables() {
        if (!this->dbname) {
            print_r("No Database used!");
            return;
        }
        try {
            $sql = "LIST TABLES FROM ".$this->dbname;
            $result = $conn->query($sql);
            $tbls = array();
            while ($tbl = $result->fetchColumn(0)) {
              if ($debug) echo $tbl."<br>";
              push_array($tbls, $tbl);
            }
        } catch (PDOException $e) {
          die("DB ERROR: ".$e->getMessage());
        }
      } // end of function list_tables

      public function insert_data($table, $json) {
        try {

        } catch (PDOException $e) {
          die("DB ERROR: ".$e->getMessage());
        }
      } // end of function insert_data

      public function modify_data($table, $json, $condition) {
        try {

        } catch (PDOException $e) {
          die("DB ERROR: ".$e->getMessage());
        }
      } // end of function modify_data

      public function delete_data($table, $condifion, $flag = false) {
        if ($flag) {
        } else {
        }

        try {

        } catch (PDOException $e) {
          die("DB ERROR: ".$e->getMessage());
        }
      } // end of function delete_data

      public function query_data($sql) {
        try {
          $result = $conn->query($sql);
          print_r($result);
        } catch (PDOException $e) {
          die("DB ERROR: ".$e->getMessage());
        }
      } // end of function query_data
*/
    } // end of class dbclass
?>

