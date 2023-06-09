<?php
  class Department
  {
    private $conn;
    private $table_name = "departments";

    public $id;
    public $name;

    public function __construct($db)
    {
      $this->conn = $db;
    }

    function add() 
    {            
      $this->name = htmlspecialchars(strip_tags($this->name));
      
      $query = "INSERT INTO `departments`(`name`) VALUES (?)";
      $stmt = $this->conn->prepare($query);

      return $stmt->execute(array($this->name));
    }

    function getOne()
    {
      $query = "SELECT * FROM `departments` WHERE `id` = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array($this->id));

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->name = $row["name"];
    }

    function getOneOfName()
    {
      $query = "SELECT * FROM `departments` WHERE `name` = ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array($this->name));

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->id = $row["id"];
      $this->name = $row["name"];
    }

    function get()
    {
      $query = "SELECT * FROM `departments` ORDER BY `name`";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();

      return $stmt;
    }

    function delete() 
    {
      $query = "DELETE FROM `departments` WHERE `id` = ?";
      $stmt = $this->conn->prepare($query);

      return $stmt->execute(array($this->id));
    }

    function update() 
    {
      $query = "UPDATE `departments` SET `name` = ? WHERE `id` = ?";
      $stmt = $this->conn->prepare($query);

      return $stmt->execute(array($this->name, $this->id));
    }
  }
?>