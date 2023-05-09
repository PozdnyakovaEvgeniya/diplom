<?php
    include_once "../config/headers.php";
    include_once "../config/databases.php";

    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);

    $number = $_POST['number'];
    
        
?>