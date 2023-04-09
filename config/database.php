<?php
$host = 'localhost';
$usernamme ='root';
$db = 'simple_login_form';
$password = '';

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

try {
    $dbh = new PDO($dsn, $usernamme, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (\PDOException $e) {
    echo $e->getMessage();
}