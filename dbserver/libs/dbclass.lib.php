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

        try {
          $this->conn = new PDO($dsn, $user, $pass);
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          if ($this->dbname != null) {
              $result = $this->use_db($dbname);
          }
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
          $result = $this->conn->query($sql);
          $dbs = array();
          foreach($result as $row) {
             if ($row['Database'] != 'mysql' &&
                 $row['Database'] != 'information_schema' &&
                 $row['Database'] != 'performance_schema' &&
                 $row['Database'] != 'sys') {
                 array_push($dbs, $row['Database']);
             }
          }
          return $dbs;
        } catch (PDOException $e) {
          die("DB ERROR: ".$e->getMessage());
        }
      } // end of function list_databases

      public function getDBname() {
        return $this->dbname;
      } // end of function getDBname

      public function create_table($tablename, $vararray) {
        try {
          $str  = "SET AUTOCOMMIT = 0;\n";
          $str .= "START TRANSACTION;\n";
          $str .= "CREATE TABLE `".$tablename."` (\n" ;
          $str .= "	`id` int(11) NOT NULL,\n";
          foreach($vararray as $row) {
             if ($row['name'] == "id" || $row['name'] == "status") {
                 $row['name'] = $tablename."_".$row['name']; // change name
             }
             $str .= "	`".$row['name']."` ".$row['type'];
             if ($row['notnull']) $str .= " NOT NULL";
             if ($row['default']) $str .= " DEFAULT '".$row['default']."'";
             $str .= ",\n";
          }
          $str .= "	`status` enum('INACTIVE','LOCKED','ACTIVE') NOT NULL DEFAULT 'INACTIVE'\n";
          $str .= ") ENGINE=INNODB;\n";
          $str .= "ALTER TABLE `".$tablename."`\n";
          $str .= "	ADD PRIMARY KEY (`id`);\n";
          $str .= "ALTER TABLE `".$tablename."`\n";
          $str .= "	MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;\n";
          $str .= "COMMIT;\n";
          //echo $str."<br>";
          $result = $this->conn->query($str);
        } catch (PDOException $e) {
          die("DB ERROR: ".$e->getMessage());
        }
      } // end of function create_table

      public function add_column($tablename, $vararray) {
        try {
          $str = "ALTER TABLE `".$tablename."`\n	ADD ";
          $fixed = false;
          foreach($vararray as $row) {
             if ($fixed) $str .= ", ";
             if ($row['name'] == "id" || $row['name'] == "status") {
                 $row['name'] = $tablename."_".$row['name']; // change name
             }
             $str .= " `".$row['name']."` ".$row['type'];
             if ($row['notnull']) $str .= " NOT NULL";
             if ($row['default']) $str .= " DEFAULT '".$row['default']."'";
             $str .= " AFTER `".$row['position']."` ";
             $fixed = true;
          }
          $str .= ";\nCOMMIT;\n";
          //echo $str."<br>";
          $result = $this->conn->query($str);
        } catch (PDOException $e) {
          die("DB ERROR: ".$e->getMessage());
        }

      } // end of function modify_table

      public function drop_table($tablename, $flag = false) {
        if ($flag) {
            $sql = "DROP TABLE ".$tablename;
            try {
              $result = $this->conn->query($sql);
            } catch (PDOException $e) {
              die("DB ERROR: ".$e->getMessage());
            }
        }
      } // end of function delete_table

      public function list_tables() {
        try {
            $sql = "SHOW TABLES";
            $result = $this->conn->query($sql);
            //return $result->fetchAll(PDO::FETCH_NUM);

            $tables = array();
            foreach($result as $row) {
               //echo $row[0]."<br>";
               array_push($tables, $row[0]);
            }
            return $tables;

        } catch (PDOException $e) {
          echo("DB ERROR: ".$e->getMessage());
        }
      } // end of function list_tables

      public function describe_table($tablename) {
        try {
            $sql = "DESCRIBE ".$tablename;
            $result = $this->conn->query($sql);
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
          echo("DB ERROR: ".$e->getMessage());
        }
      } // end of function describe_table

      public function insert_data($tablename, $vararray) {
        try {
           $str = "INSERT INTO `".$tablename."` (";
           $fixed = false;
           foreach($vararray as $key) {
              if ($fixed) $str .= ", ";
              if ($key['key'] == "id" || $key['key'] == "status") {
                  $key['key'] = $tablename."_".$key['key'];
              }
              $str .= "`".$key['key']."`";
              $fixed = true;
           }
           $str .= ", `status`) VALUES (";
           $fixed = false;
           foreach($vararray as $val) {
              if ($fixed) $str .= ", ";
              if ($val['val'] == "CURRENT_TIME") {
                  $str .= $val['val'];
              } else if ($val['val'] == null) {
                  $str .= "null";
              } else {
                  $str .= "'".$val['val']."'";
              }
              $fixed = true;
           }
           $str .= ", 'ACTIVE');\nCOMMIT;\n";
           echo $str."<br>";
           $result = $this->conn->query($str);
        } catch (PDOException $e) {
          die("DB ERROR: ".$e->getMessage());
        }
      } // end of function insert_data

      public function modify_data($tablename, $vararray, $cond) {
        $str = "UPDATE `".$tablename."` SET ";
        $fixed = false;
        foreach($vararray as $row) {
            if ($fixed) $str .= ", ";
            if ($row['key'] == 'id' || $row['key'] == 'status') {
                $row['key'] = $tablename."_".$row['key'];
            }
            $str .= "`".$row['key']."` = '".$row['val']."'"; 
            $fixed = true;
        }
        $str .= " WHERE ".$cond.";\nCOMMIT;\n";
        try {
          $result = $this->conn->query($str);
        } catch (PDOException $e) {
          die("DB ERROR: ".$e->getMessage());
        }
      } // end of function modify_data

      public function delete_data($tablename, $cond, $flag = false) {
        if ($flag) {
            $str = "DELETE FROM `".$tablename."` WHERE ".$cond;
        } else {
            $str = "UPDATE `".$tablename."` SET `status` = 'INACTIVE' WHERE ".$cond;
        }
        $str .= ";\nCOMMIT;\n";
        try {
          $result = $this->conn->query($str);
        } catch (PDOException $e) {
          die("DB ERROR: ".$e->getMessage());
        }
      } // end of function delete_data

      public function query_data($sql) {
        try {
          $result = $this->conn->query($sql);
          return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
          die("DB ERROR: ".$e->getMessage());
        }

      } // end of function query_data

    } // end of class dbclass
?>

