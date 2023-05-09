<?php
    class User
    {
        private $conn;
        private $table_name = "users";

        public $id;
        public $employee_id;
        public $password;

        public function __construct($db)
        {
            $this->conn = $db;
        }

        function create() 
        {            
            $this->employee_id = htmlspecialchars(strip_tags($this->employee_id));
            $this->password = htmlspecialchars(strip_tags($this->password));
            
            $password = password_hash($this->password, PASSWORD_BCRYPT);
            
            $query = "INSERT INTO users (`employee_id`, `password`) VALUES (?, ?)";
            $stmt = $this->conn->prepare($query);

            return $stmt->execute(array($this->employee_id, $password));
        }
    }
?>