<?php
$hostname = 'localhost';
$dbname = 'dicioralho';
$username = 'admin';
$password = 'admin';

try {
    $conn = new PDO("pgsql:host=$hostname;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
session_start();
?>