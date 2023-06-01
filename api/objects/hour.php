<?php
  class Hour
  {
    private $conn;
    private $table_name = "hours";

    public $id;
    public $employee_id;
    public $date_id;
    public $hours;

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
    }  
  }
?>