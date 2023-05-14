<?php
  class Hour
  {
    private $conn;
    private $table_name = "hours";

    public $id;
    public $employee_id;
    public $date;
    public $hours;
    public $overtime;
    public $time_off;

    public function __construct($db)
    {
      $this->conn = $db;
    }

    
  }
?>