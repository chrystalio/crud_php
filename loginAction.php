<?php
// Comment out the following lines when deploying to production
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once("dbConnection.php");

// Retrieve the submitted username and password
$username = $_POST['username'];
$password = $_POST['password'];

// Validate and sanitize the inputs
$username = trim($username);
$password = trim($password);

// Validate the inputs
if (empty($username) || empty($password)) {
    $errorMessage = "Please enter both username and password.";
    header("Location: login.php?errorMessage=" . urlencode($errorMessage));
    exit();
}

// Sanitize the inputs
$username = mysqli_real_escape_string($mysqli, $username);
$password = mysqli_real_escape_string($mysqli, $password);

// Check if the username exists in the database
$stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

$result = $stmt->get_result();

// Check if a matching user record is found
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $storedPassword = $row['password'];

    // Verify the submitted password
    if (password_verify($password, $storedPassword)) {
        // Authentication successful
        session_start();
        $_SESSION['username'] = $username;
        header('Location: login.php'); // Redirect to a protected page (e.g., dashboard.php)
        exit();
    }
}

// Authentication failed
$errorMessage = "Invalid username or password!";
header("Location: login.php?errorMessage=" . urlencode($errorMessage));

// If the user is already logged in, prevent them from accessing the login page again
if (isset($_SESSION['username'])) {
    header("Location: index.php");
}

$stmt->close();
?>
