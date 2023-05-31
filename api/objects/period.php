<?php
  class Period
  {
    private $conn;
    private $table_name = "periods";

    public $id;
    public $status_id;
    public $employee_id;
    public $start;
    public $end;

    public function __construct($db)
    {
      $this->conn = $db;
    }  

    function add() 
    {
      $this->status_id = htmlspecialchars(strip_tags($this->status_id));
      $this->employee_id = htmlspecialchars(strip_tags($this->employee_id));
      $this->start = htmlspecialchars(strip_tags($this->start));
      $this->end = htmlspecialchars(strip_tags($this->end));
      
      $query = "INSERT INTO `periods`(`status_id`, `employee_id`, `start`, `end`) VALUES (?, ?, ?, ?)";
      $stmt = $this->conn->prepare($query);

      return $stmt->execute(array($this->status_id, $this->employee_id, $this->start, $this->end));
    }

    // function delete() 
    // {
    //   $query = "DELETE FROM `shifts` WHERE `id` = ?";
    //   $stmt = $this->conn->prepare($query);

    //   return $stmt->execute(array($this->id));
    // }

    // function getOfDepartment()
    // {
    //   $query = "SELECT * FROM `shifts` WHERE `department_id` = ?";
    //   $stmt = $this->conn->prepare($query);
    //   $stmt->execute(array($this->department_id));

    //   return $stmt;
    // }  
  }
?>