<?php
  class Status
  {
    private $conn;
    private $table_name = "statuses";

    public $id;
    public $name;
    public $department_id;
    public $status;

    public function __construct($db)
    {
      $this->conn = $db;
    }  

    function get()
    {
      $query = "SELECT * FROM `statuses`";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();

      return $stmt;
    }  
  }
?>