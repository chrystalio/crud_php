<?php
// Comment out the following lines when deploying to production
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the database connection file
require_once("dbConnection.php");

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION['username'])) {
	header("Location: index.php");
	exit();
}

// Fetch data in descending order (latest entry first)
$result = mysqli_query($mysqli, "SELECT * FROM users ORDER BY id DESC");
?>

<html>
<head>	
    <title>Login Page</title>
</head>

<body>
    <h2>Login</h2>
    <?php if (isset($_GET['errorMessage'])) { ?>
        <p><font color="red"><?php echo htmlspecialchars($_GET['errorMessage']); ?></font></p>
    <?php } ?>
    <form action="loginAction.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>
        
        <input type="submit" value="Login">
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </form>

    <h2>Default User</h2>
    <p>
        <strong>Username:</strong> admin<br>
        <strong>Password:</strong> admin123
    </p>

</body>
</html>
