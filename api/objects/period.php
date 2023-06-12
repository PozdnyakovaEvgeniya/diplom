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
    public $hours;

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
      $this->hours = $this->hours ? htmlspecialchars(strip_tags($this->hours)) : NULL;
      
      $query = "INSERT INTO `periods`(`status_id`, `employee_id`, `start`, `end`, `hours`) VALUES (?, ?, ?, ?, ?)";
      $stmt = $this->conn->prepare($query);

      return $stmt->execute(array($this->status_id, $this->employee_id, $this->start, $this->end, $this->hours));
    }

    function delete() 
    {
      $query = "DELETE FROM `periods` WHERE `id` = ?";
      $stmt = $this->conn->prepare($query);

      return $stmt->execute(array($this->id));
    }

    function getOfMonth($start, $end)
    {
      $query = "SELECT * FROM `periods` WHERE `employee_id` = ? AND ((`start` >= '$start' AND `start` < '$end') || (`end` >= '$start' AND `end` < '$end') || (`start` < '$start' AND `end` >= '$end')) ORDER BY `start`";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array($this->employee_id));

      return $stmt;
    }  

    function getOne() {
      $query = "SELECT * FROM `periods` WHERE `employee_id` = ? AND `start` = ? AND `status_id` = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array($this->employee_id, $this->start, $this->status_id));

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->hours = $row["hours"];
    }

    function getOfId() {
      $query = "SELECT * FROM `periods` WHERE `id` = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array($this->id));

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->status_id = $row["status_id"];
      $this->employee_id = $row["employee_id"];
      $this->hours = $row["hours"];
    }

    function getOfDate($date) {
      $query = "SELECT * FROM `periods` WHERE `employee_id` = ? AND `start` <= '$date' AND `end` >= '$date'";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array($this->employee_id));

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->status_id = $row["status_id"];
    }
  }
?>