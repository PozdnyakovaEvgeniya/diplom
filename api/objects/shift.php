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

    function add() 
    {
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->department_id = htmlspecialchars(strip_tags($this->department_id));
      
      $query = "INSERT INTO `shifts`(`name`, `department_id`) VALUES (?, ?)";
      $stmt = $this->conn->prepare($query);

      return $stmt->execute(array($this->name, $this->department_id));
    }

    function getOfDepartment()
    {
      $query = "SELECT * FROM `shifts` WHERE `department_id` = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array($this->department_id));

      return $stmt;
    }  
  }
?>