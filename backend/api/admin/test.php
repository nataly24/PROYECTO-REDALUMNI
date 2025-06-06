<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $pdo = new PDO("mysql:host=127.0.0.1;dbname=proyectolaravelredalumni", "root", "");
    echo "Connected successfully";
    
    $result = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "\nTables in database:\n";
    print_r($result);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>