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

// Check if the expense ID is provided via GET parameter
if (isset($_GET['id'])) {
    // Get the expense ID from the GET parameter
    $expense_id = $_GET['id'];

    // Prepare SQL query to delete the expense
    $sql = "DELETE FROM expense WHERE id = $expense_id";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        // Redirect to a page after successful deletion (optional)
        header('Location: dashboard.php');
        exit; // Make sure to exit after redirection
    } else {
        // Return an error message if deletion fails
        echo "Error deleting expense: " . $conn->error;
    }
} else {
    // Return an error message if expense ID is not provided
    echo "Expense ID not provided";
}

// Close the database connection if no longer needed
$conn->close();
?>