<?php
  class Employee
  {
    private $conn;
    private $table_name = "employees";

    public $id;
    public $number;
    public $surname;
    public $name;
    public $patronymic;
    public $job_title;
    public $department_id;
    public $status;
    public $working_mode;
    public $password;

    public function __construct($db)
    {
      $this->conn = $db;
    }

    function create() 
    {            
      $this->number = htmlspecialchars(strip_tags($this->number));
      $this->surname = htmlspecialchars(strip_tags($this->surname));
      $this->name = htmlspecialchars(strip_tags($this->name));
      $this->patronymic = htmlspecialchars(strip_tags($this->patronymic));
      $this->job_title = htmlspecialchars(strip_tags($this->job_title));
      $this->department_id = htmlspecialchars(strip_tags($this->department_id));
      $this->status = htmlspecialchars(strip_tags($this->status));
      $this->working_mode = htmlspecialchars(strip_tags($this->working_mode));
      $this->password = htmlspecialchars(strip_tags($this->password));
      
      $password = empty($_POST['password']) ? NULL : password_hash($this->password, PASSWORD_BCRYPT);
      
      $query = "INSERT INTO `employees`(`number`, `surname`, `name`, `patronymic`, `job_title`, `department_id`, `status`, `working_mode`, `password`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $this->conn->prepare($query);

      return $stmt->execute(array($this->number, $this->surname, $this->name, $this->patronymic, $this->job_title, $this->department_id, $this->status, $this->working_mode, $password));
    }

    function findNumber() {
      $this->number=htmlspecialchars(strip_tags($this->number));

      $query = "SELECT * FROM `employees` WHERE `number` = ? LIMIT 0,1";
      $stmt = $this->conn->prepare($query);
      $stmt->execute([$this->number]);
      $num = $stmt->rowCount();
      
      if ($num > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->number = $row['number'];
        $this->surname = $row['surname'];
        $this->name = $row['name'];
        $this->patronymic = $row['patronymic'];
        $this->job_title = $row['job_title'];
        $this->department_id = $row['department_id'];
        $this->status = $row['status'];
        $this->working_mode = $row['working_mode'];
        $this->password = $row['password'];

        return true;
      }

      return false;
    }

    function getFullName() {
      return $this->surname." ".$this->name." ".$this->patronymic;
    }

    function getShortName() {
      return $this->surname." ".mb_substr($this->name, 0, 1).".".mb_substr($this->patronymic, 0, 1).".";
    }
  }
?>