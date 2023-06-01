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

    function add() 
    {
      $this->date = htmlspecialchars(strip_tags($this->date));
      $this->shift_id = htmlspecialchars(strip_tags($this->shift_id));
      $this->hours = htmlspecialchars(strip_tags($this->hours));
      $this->status = htmlspecialchars(strip_tags($this->status));

      $query = "SELECT * FROM `dates` WHERE `date` = ? AND `shift_id` = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array($this->date, $this->shift_id));
      $num = $stmt->rowCount();

      if ($num == 0) {
        $query = "INSERT INTO `dates`(`date`, `shift_id`, `hours`, `status`) VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute(array($this->date, $this->shift_id, $this->hours, $this->status));
      } else {
        $query = "UPDATE `dates` SET `hours` = ?, `status` = ? WHERE `date` = ? AND `shift_id` = ?";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute(array($this->hours, $this->status, $this->date, $this->shift_id));
      }
      
    }

    function getOfMonth($start, $end)
    {
      $query = "SELECT * FROM `dates` WHERE `shift_id` = ? AND `date` >= ? AND `date` < ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array($this->shift_id, $start, $end));

      return $stmt;
    }  

    function getOne() 
    {
      $query = "SELECT * FROM `dates` WHERE `shift_id` = ? AND `date` = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array($this->shift_id, $this->date));

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->id = $row['id'];
      $this->date = $row['date'];
      $this->shift_id = $row['shift_id'];
      $this->hours = $row['hours'];
      $this->status = $row['status'];
    }
  }
?>