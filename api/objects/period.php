<?php
  class Period
  {
    private $conn;
    private $table_name = "periods";

    public $id;
    public $status;
    public $employee_id;
    public $start;
    public $end;
    public $hours;

    public function __construct($db)
    {
      $this->conn = $db;
    }  

    function add() 
    {
      $this->status = htmlspecialchars(strip_tags($this->status));
      $this->employee_id = htmlspecialchars(strip_tags($this->employee_id));
      $this->start = htmlspecialchars(strip_tags($this->start));
      $this->end = htmlspecialchars(strip_tags($this->end));
      $this->hours = htmlspecialchars(strip_tags($this->hours));
      
      $query = "INSERT INTO `periods`(`status`, `employee_id`, `start`, `end`, `hours`) VALUES (?, ?, ?, ?, ?)";
      $stmt = $this->conn->prepare($query);

      return $stmt->execute(array($this->status, $this->employee_id, $this->start, $this->end, $this->hours));
    }

    function delete() 
    {
      $query = "DELETE FROM `periods` WHERE `id` = ?";
      $stmt = $this->conn->prepare($query);

      return $stmt->execute(array($this->id));
    }

    function getOfMonth($start, $end)
    {
      $query = "SELECT * FROM `periods` WHERE `employee_id` = ? AND (`start` >= '$start' AND `start` < '$end') || (`end` >= '$start' AND `end` < '$end') || (`start` < '$start' AND `end` >= '$end') ORDER BY `start`";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array($this->employee_id));

      return $stmt;
    }  
  }
?>