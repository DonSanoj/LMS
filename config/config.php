<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "elearning";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_errno) {
    die("Connection error: " . $conn->connect_error);
}

return $conn;

?>