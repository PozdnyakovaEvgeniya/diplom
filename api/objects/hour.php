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

    function add() 
    {
      $this->date_id = htmlspecialchars(strip_tags($this->date_id));
      $this->employee_id = htmlspecialchars(strip_tags($this->employee_id));

      $query = "SELECT * FROM `hours` WHERE `date_id` = ? AND `employee_id` = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array($this->date_id, $this->employee_id));
      $num = $stmt->rowCount();

      if ($num == 0) {
        $query = "INSERT INTO `hours`(`date_id`, `employee_id`) VALUES (?, ?)";

        $stmt = $this->conn->prepare($query);

        return $stmt->execute(array($this->date_id, $this->employee_id));
      } 
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