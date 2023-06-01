<?php
  class Status
  {
    private $conn;
    private $table_name = "statuses";

    public $id;
    public $name;
    public $department_id;
    public $status;

    public function __construct($db)
    {
      $this->conn = $db;
    }  

    function get()
    {
      $query = "SELECT * FROM `statuses`";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();

      return $stmt;
    }  

    function getOne()
    {
      $query = "SELECT * FROM `statuses` WHERE `id` = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array($this->id));

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->name = $row["name"];
      $this->short_name = $row["short_name"];
    }  
  }
?>