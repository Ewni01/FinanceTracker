<?php
require_once 'config.php';

function register_user($username, $email, $password) {
    global $pdo;
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    
    if($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);
        
        if($stmt->execute()) {
            return true;
        }
    }
    return false;
}

function login_user($email, $password) {
    global $pdo;
    
    $sql = "SELECT id, username, password FROM users WHERE email = :email";
    
    if($stmt = $pdo->prepare($sql)) {
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        
        if($stmt->execute()) {
            if($stmt->rowCount() == 1) {
                if($row = $stmt->fetch()) {
                    $id = $row['id'];
                    $username = $row['username'];
                    $hashed_password = $row['password'];
                    
                    if(password_verify($password, $hashed_password)) {
                        $_SESSION['user_id'] = $id;
                        $_SESSION['username'] = $username;
                        return true;
                    }
                }
            }
        }
    }
    return false;
}
?>