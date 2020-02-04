<?php

class Database
{
  // DB Params
  protected $host = 'localhost';
  protected $db_name = 'quantoxinternship';
  protected $username = 'root';
  protected $password = '';
  protected $conn;

  // DB Connect  
    public function connect()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:host=' . $this->host .';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
  // $conn->query("SET COLLATION_CONNECTION='utf8_general_ci'");
    return $this->conn;
    }
}
