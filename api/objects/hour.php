<?php
  class Hour
  {
    private $conn;
    private $table_name = "hours";

    public $id;
    public $employee_id;
    public $date_id;
    public $hours;
    public $overtime;
    public $time_off;
    public $status;

    public function __construct($db)
    {
      $this->conn = $db;
    }  

    function getOne()
    {
      $query = "SELECT * FROM `hours` WHERE `employee_id` = ? AND `date_id` = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array($this->employee_id, $this->date_id));

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->id = $row["id"];
      $this->hours = $row["hours"];
      $this->overtime = $row["overtime"];
      $this->time_off = $row["time_off"];
      $this->status = $row["status"];
    }  

    function add() {
      $query = "SELECT * FROM `hours` WHERE `employee_id` = ? AND `date_id` = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array($this->employee_id, $this->date_id));

      if($stmt) {
        $query = "UPDATE `hours` SET `overtime`=? WHERE `employee_id` = ? AND `date_id` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(array($this->time_off, $this->employee_id, $this->date_id));
      } else {
        $query = "INSERT INTO `hours`(`employee_id`, `date_id`, `time_off`) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(array($this->employee_id, $this->date_id, $this->time_off));
      }
    }
  }
?>