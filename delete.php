<?php
// Include the database connection file
require_once("dbConnection.php");

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION['username'])) {
	header("Location: login.php");
	exit();
}


// Get id parameter value from URL and
$id = $_GET['id'];

$stmt = $mysqli->prepare("DELETE FROM employees WHERE id = ?");

// Bind parameter ke statement
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location:index.php");
} else {
    echo "<font color='red'>Data delete failed." . $stmt->error;
    echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
}

$stmt->close();

?>
