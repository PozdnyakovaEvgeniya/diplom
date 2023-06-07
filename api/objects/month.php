<?php
  class Month
  {
    private $conn;
    private $table_name = "months";

    public $id;
    public $department_id;
    public $year;
    public $month;

    public function __construct($db)
    {
      $this->conn = $db;
    }  

    function add() 
    {
      $this->department_id = htmlspecialchars(strip_tags($this->department_id));
      $this->year = htmlspecialchars(strip_tags($this->year));
      $this->month = htmlspecialchars(strip_tags($this->month));

      $query = "INSERT INTO `months`(`department_id`, `year`, `month`) VALUES (?, ?, ?)";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array($this->department_id, $this->year, $this->month));
    }

    function getOne()
    {
      $query = "SELECT * FROM `months` WHERE `department_id` = ? AND `year` = ? AND `month` = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array($this->department_id, $this->year, $this->month));
      
      return $stmt;
    }
  }
?>