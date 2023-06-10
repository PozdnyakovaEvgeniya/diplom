<?php
  class Token
  {
    private $conn;
    private $table_name = "tokens";

    public $id;
    public $employee_id;
    public $token;
    public $valid_until;

    public function __construct($db)
    {
      $this->conn = $db;
    }

    function create() 
    {         
      $this->employee_id = htmlspecialchars(strip_tags($this->employee_id));

      $this->token = sha1(random_bytes(100)) . sha1(random_bytes(100));
      $timespamp = new DateTimeImmutable();
      $this->valid_until = $timespamp->modify('+72 hours')->format('Y-m-d H:i:s');
      
      $query = "INSERT INTO `tokens`(`employee_id`, `token`, `valid_until`) VALUES (?, ?, ?)";
      $stmt = $this->conn->prepare($query);

      return $stmt->execute(array($this->employee_id, $this->token, $this->valid_until));
    }

    function getOfToken() {
      $timespamp = new DateTimeImmutable();

      $query = "SELECT * FROM `tokens` WHERE `token` = ? AND `valid_until` > ?";
      $stmt = $this->conn->prepare($query);
      $stmt->execute(array($this->token, $timespamp->format('Y-m-d H:i:s')));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->employee_id = $row["employee_id"];
    }

    function remove() {
      $query = "DELETE FROM `tokens` WHERE `token` = ?";
      $stmt = $this->conn->prepare($query);
      return $stmt->execute(array($this->token));
    }

    function delete() {
      $query = "DELETE FROM `tokens` WHERE `employee_id` = ?";
      $stmt = $this->conn->prepare($query);
      return $stmt->execute(array($this->employee_id));
    }
  }
?>