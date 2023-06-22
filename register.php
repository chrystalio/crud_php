<?php
// Comment out the following lines when deploying to production
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Include the database connection file
require_once("dbConnection.php");

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION['username'])) {
	header("Location: index.php");
	exit();
}


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Validate and sanitize the inputs
    $username = trim($username);
    $password = trim($password);
    $email = trim($email);

    // Validate the inputs
    if (empty($username) || empty($password)) {
        $errorMessage = "Please enter both username and password.";
    } else {
        // Sanitize the inputs
        $username = mysqli_real_escape_string($mysqli, $username);
        $email = mysqli_real_escape_string($mysqli, $email);
        $password = mysqli_real_escape_string($mysqli, $password);

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if the username already exists in the database
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errorMessage = "Username already exists. Please choose a different username.";
        } else {
            // Insert the new user into the database
            $stmt = $mysqli->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashedPassword);
            if ($stmt->execute()) {
                // User registration successful
                header('Location: login.php'); // Redirect to the login page
                exit();
            } else {
                $errorMessage = "Failed to register user.";
                header("Location: register.php?errorMessage=" . urlencode($errorMessage));
            }
        }
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registration Page</title>
</head>
<body>
    <h2>Register</h2>
    <?php if (isset($errorMessage)) { ?>
        <p><font color="red"><?php echo $errorMessage; ?></font></p>
    <?php } ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>
