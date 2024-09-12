<?php
// edit_expense.php

// Check if an expense ID is provided
if (isset($_GET['id'])) {
    $expense_id = $_GET['id'];

    // Include your database connection logic here if not already included
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

    // Query to fetch expense details based on the provided ID
    $sql = "SELECT amount, type, comment FROM expense WHERE id = '$expense_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $amount = $row["amount"];
        $category = $row["type"];
        $comment = $row["comment"];
    } else {
        // If expense ID is not found, redirect the user to the homepage or display an error message
        header("Location: dashboard.php");
        exit();
    }

    $conn->close();
} else {
    // If no expense ID is provided, redirect the user to the homepage or display an error message
    header("Location: dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Expense</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fafbfc;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h2 {
            color: #02b3e4;
            margin-left: 680px;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        input[type="number"],
        input[type="text"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #02b3e4;
            color: #fff;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0288a7;
        }
    </style>
</head>
<body>
    <h2>Edit Expense</h2>
    <form action="update_expense.php" method="post">
        <input type="hidden" name="expense_id" value="<?php echo $expense_id; ?>">
        <label for="amount">Amount:</label>
        <input type="number" id="amount" name="amount" value="<?php echo $amount; ?>" required><br>
         <label for="category">Category:</label>
        <input type="text" id="category" name="type" value="<?php echo $category; ?>" required><br><br>
        <label for="comment">Comment:</label>
        <input type="text" id="comment" name="comment" value="<?php echo $comment; ?>"><br>
        <input type="submit" value="Update Expense">
    </form>
</body>

</html>