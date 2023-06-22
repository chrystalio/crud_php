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

// Get id from URL parameter
$id = $_GET['id'];

// Siapkan statement untuk placeholder ID
$stmt = $mysqli->prepare("SELECT * FROM employees WHERE id = ?");

// Bind parameter ke statement
$stmt->bind_param("i", $id);

// Jalankan query
$stmt->execute();

// Ambil hasil query
$result = $stmt->get_result();

// Ambil data dari hasil query
$resultData = $result->fetch_assoc();

$name = $resultData['name'];
$age = $resultData['age'];
$email = $resultData['email'];

// tutup statement
$stmt->close();
?>
<html>
<head>	
	<title>Edit Data</title>
</head>

<body>
    <h2>Edit Data</h2>
    <p>
	    <a href="index.php">Home</a>
    </p>
	
	<form name="edit" method="post" action="editAction.php">
		<table border="0">
			<tr> 
				<td>Name</td>
				<td><input type="text" name="name" value="<?php echo $name; ?>"></td>
			</tr>
			<tr> 
				<td>Age</td>
				<td><input type="number" name="age" value="<?php echo $age; ?>" min="0"></td>
			</tr>
			<tr> 
				<td>Email</td>
				<td><input type="email" name="email" value="<?php echo $email; ?>"></td>
			</tr>
			<tr>
				<td><input type="hidden" name="id" value=<?php echo $id; ?>></td>
				<td><input type="submit" name="update" value="Update"></td>
			</tr>
		</table>
	</form>
</body>
</html>
