<?php
// update_expense.php

    // Include your database connection logic here
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

    // Retrieve expense ID and updated values from form submission
    $expense_id = $_POST['expense_id'];
    $amount = $_POST['amount'];
    $category = $_POST['type'];
    $comment = $_POST['comment'];

    // Update the row in the database with the new values
    $sql = "UPDATE expense SET amount='$amount', type='$category', comment='$comment' WHERE id='$expense_id'";

    if ($conn->query($sql) === TRUE) {
        // If update is successful, redirect back to the page displaying expenses
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();

?>