<?php
header("Access-Control-Allow-Origin: http://localhost:4200");
$serverPath = getenv("MYSQL_SERVER");
$userName = getenv("MYSQL_USER");
$password = getenv("MYSQL_PASSWORD");
$dbName = getenv("MYSQL_DATABASE");

$conn = new mysqli($serverPath, $userName, $password, $dbName);
if ($conn->connect_error) {
    die("Connection error:" . $conn->connect_errno);
}

$query = "DELETE FROM employees WHERE username = ?";
$statement = $conn->prepare($query);
$statement->bind_param("s", $_POST["user"]);
$statement->execute();

$conn->close();

