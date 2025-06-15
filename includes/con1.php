<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
      $host = "localhost";
      $user = "root";
      $password = "";
      $database = "finance_tracker";

      session_start();
        // Create connection

        $data = mysqli_connect($host, $user, $password, $database);

        if ($data == false){
            die("Connection error");
        }


    



     ?>