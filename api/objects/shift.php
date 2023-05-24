<?php
  class Shift
  {
    private $conn;
    private $table_name = "shifts";

    public $id;
    public $name;
    public $department_id;
    public $status;

    public function __construct($db)
    {
      $this->conn = $db;
    }  

    function getOfDepartment($start, $end)
    {
      $query = "SELECT * FROM `shifts` WHERE `department_id` = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array($this->department_id));

      return $stmt;
    }  
  }
?>