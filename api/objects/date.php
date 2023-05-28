<?php
  class Date
  {
    private $conn;
    private $table_name = "dates";

    public $id;
    public $date;
    public $shift_id;
    public $hours;
    public $status;

    public function __construct($db)
    {
      $this->conn = $db;
    }  

    function getOfMonth($start, $end)
    {
      $query = "SELECT * FROM `dates` WHERE `shift_id` = ? AND `date` >= ? AND `date` < ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array($this->shift_id, $start, $end));

      return $stmt;
    }  
  }
?>