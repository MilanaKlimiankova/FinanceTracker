<?php
$servername = "127.0.0.1";
$username = "root";
$pass = "";
$dbname = "finance_tracker";
$salt = md5(1231);

// Create connection
$link = mysqli_connect($servername, $username, $pass, $dbname) or die("Ошибка " . mysqli_error($link));

?>
