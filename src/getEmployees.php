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

if (isset($_GET["role"])) {
    $statement = $conn->prepare("SELECT * FROM employees WHERE role like concat('%', ?, '%')");
    $statement->bind_param("s", $_GET["role"]);
}
else {
    if (isset($_GET["name"])) {
        $statement = $conn->prepare("SELECT * FROM employees WHERE name = ?");
        $statement->bind_param("s", $_GET["name"]);
    }
    else {
        $statement = $conn->prepare("SELECT * FROM employees");
    }
}

$statement->execute();
$result = $statement->get_result();
$employees = array();
while ($row = mysqli_fetch_array($result)) {
    $employees[] = $row;
}
echo json_encode($employees);

$conn->close();

