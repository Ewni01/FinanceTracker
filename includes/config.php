<?php
session_start();

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // Change as per your setup
define('DB_PASSWORD', ''); // Change as per your setup
define('DB_NAME', 'finance_tracker');




// Attempt to connect to MySQL database
try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

// Redirect to login page if not logged in
function require_login() {
    if(!isset($_SESSION['user_id'])) {
        header("location: login.php");
        exit;
    }
}
?>