<?php
  class Hour
  {
    private $conn;
    private $table_name = "hours";

    public $id;
    public $employee_id;
    public $date;
    public $hours;
    public $overtime;
    public $time_off;

    public function __construct($db)
    {
      $this->conn = $db;
    }  

    function getOfMonth($start, $end)
    {
      $query = "SELECT * FROM `hours` WHERE `employee_id` = ? AND `date` >= ? AND `date` < ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array($this->employee_id, $start, $end));

      return $stmt;
    }  
  }
?>