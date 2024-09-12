<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expense";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$a = $_POST['expense'];
$b = $_POST["type"];
$c = $_POST['comment'];
$d = date("d/m/Y");

$sql = "INSERT INTO expense (amount, type, comment, day) VALUES ($a, '$b', '$c', '$d')";

if ($conn->query($sql) === TRUE) {
    // Fetch today's expenses after adding the new expense
    $today = date("d/m/Y");
    $sql0 = "SELECT id, amount, comment, day, type FROM expense WHERE day = '$today' ORDER BY type ASC ";
    $result0 = $conn->query($sql0);

    // Redirect back to the previous page
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>