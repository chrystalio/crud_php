<?php

// Turn off all error reporting (for production use, not for development)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
require_once("dbConnection.php");

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION['username'])) {
	header("Location: login.php");
	exit();
}


// Fetch data in descending order (lastest entry first)
$result = mysqli_query($mysqli, "SELECT * FROM employees ORDER BY id DESC");
?>

<html>
<head>	
	<title>Homepage</title>
</head>

<body>
	<h2>Homepage</h2>

	<p>
		<a href="add.php">Add New Data</a> |
		<a href="logout.php">Logout</a>
	</p>
	<table width='80%' border=0>
		<tr bgcolor='#DDDDDD'>
			<td><strong>Name</strong></td>
			<td><strong>Age</strong></td>
			<td><strong>Email</strong></td>
			<td><strong>Action</strong></td>
		</tr>
		<?php
		// Fetch the next row of a result set as an associative array
		while ($res = mysqli_fetch_assoc($result)) {
			echo "<tr>";
			echo "<td>".$res['name']."</td>";
			echo "<td>".$res['age']."</td>";
			echo "<td>".$res['email']."</td>";	
			echo "<td><a href=\"edit.php?id=$res[id]\">Edit</a> | 
			<a href=\"delete.php?id=$res[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";
		}
		?>
	</table>
</body>
</html>
