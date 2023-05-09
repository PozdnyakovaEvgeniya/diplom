<?php

    class Database
    {
        private $host = "localhost";
        private $db_name = "api";
        private $username = "root";
        private $password = "root";
        private $charset = 'utf8mb4';
        private $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        public $conn;

        public function getConnection()
        {
            $this->conn = null;

            try {
                $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=" . $this->charset, $this->username, $this->password, $this->options);
                $this->conn->exec("set names utf8");
            } catch (PDOException $exception) {
                echo "Ошибка соединения с БД: " . $exception->getMessage();
            }

            return $this->conn;
        }
    }
?>