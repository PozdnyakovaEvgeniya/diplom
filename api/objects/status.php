<?php
  class Status
  {
    private $conn;
    private $table_name = "statuses";

    public $id;
    public $name;
    public $short_name;
    public $hourly;

    public function __construct($db)
    {
      $this->conn = $db;
    }  

    function add() 
    {
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->short_name = htmlspecialchars(strip_tags($this->short_name));
      $this->hourly = htmlspecialchars(strip_tags($this->hourly));
      
      $query = "INSERT INTO `statuses`(`name`, `short_name`, `hourly`) VALUES (?, ?, ?)";
      $stmt = $this->conn->prepare($query);

      return $stmt->execute(array($this->name, $this->short_name, $this->hourly));
    }

    function get() {
      $query = "SELECT * FROM `statuses`";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();

      return $stmt;
    }
  }
?>