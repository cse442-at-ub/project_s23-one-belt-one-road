<?php
// Check if the form has been submitted
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Retrieve the username and password from the form data
	$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// TODO: Authenticate the user (checking if the username and password match a user in a database)
	// Check if the user is authenticated
	$hashed_password = password_hash($password, PASSWORD_DEFAULT);
	if ($username == 'myusername' && $password == 'mypassword') {
		// Set a session variable to indicate that the user is logged in
		$_SESSION['logged_in'] = true;

		// Redirect to the home page (or some other protected page)
		header('Location: landing.php');
		exit();
	} else {
		// Display an error message
		$error_msg = 'Invalid username or password. Please try again.';
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Log In - Ubay</title>
</head>
<body>
	<h1>Log In</h1>

	<?php
	// Display an error message (if any)
	if (isset($error_msg)) {
		echo '<p style="color: red;">' . $error_msg . '</p>';
	}
	?>

	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
		<label for="username">Username:</label>
		<input type="text" id="username" name="username" required><br><br>

		<label for="password">Password:</label>
		<input type="password" id="password" name="password" required><br><br>

		<input type="submit" value="Log In">
	</form>
	<p>New User?<a href="register.php"> Click here</a> to register</p>
</body>
</html>
