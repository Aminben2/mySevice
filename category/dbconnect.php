<?php
try {
    $host = 'localhost';
    $db = 'myservice1';
    $user = 'root';
    $password = '';
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $connection = new PDO($dsn, $user, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error :" . $e->getMessage();
}
