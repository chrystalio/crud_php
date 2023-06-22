<?php
// Include the database connection file
require_once("dbConnection.php");

// Menampilkan pesan error jika ada
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

session_start();

if (!isset($_SESSION['username'])) {
	header("Location: login.php");
	exit();
}

if (isset($_POST['update'])) {
	// Escape special characters in a string for use in an SQL statement
	$id = htmlspecialchars(mysqli_real_escape_string($mysqli, $_POST['id']));
	$name = htmlspecialchars(mysqli_real_escape_string($mysqli, $_POST['name']));
	$age = htmlspecialchars(mysqli_real_escape_string($mysqli, $_POST['age']));
	$email = htmlspecialchars(mysqli_real_escape_string($mysqli, $_POST['email']));	

	$stmt = $mysqli->prepare("UPDATE employees SET `name` = ?, `age` = ?, `email` = ? WHERE `id` = ?");

	// Bind parameter ke statement
	$stmt->bind_param("sisi", $name, $age, $email, $id);

	
	// Cek apakah query berhasil dieksekusi atau tidak
	if($stmt->execute()) {
		echo "<font color='green'>Data updated successfully.";
		echo "<br/><a href='index.php'>View Result</a>";
	} else {
		echo "<font color='red'>Data update failed." . $stmt->error;
		echo "<br/><a href='javascript:self.history.back();'>Go Back</a>";
	}
}
