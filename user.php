<?php
session_start();
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "expense";

$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to sanitize input
function sanitize($data)
{
    global $conn;
    return mysqli_real_escape_string($conn, trim($data));
}

// Sign Up
if (isset($_POST['signup'])) {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['email'] = $email;
        header("Location: index.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Sign In
if (isset($_POST['signin'])) {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['email'] = $email;
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "User not found";
    }
}

mysqli_close($conn);
?>