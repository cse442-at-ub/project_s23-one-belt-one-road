<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// Get the form input values
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// Validate the input
	$errors = [];
	if (empty($username)) {
		$errors[] = "Username is required.";
	}
    elseif (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
		$errors[] = "Username must contain only alphanumeric characters";
	}
	if (empty($email)) {
	
		$errors[] = "Email is required.";
	
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors[] = "Invalid email format.";
	}

	if (empty($password)) {
		$errors[] = "Password is required.";
	} elseif (strlen($password) < 8) {
		$errors[] = "Password must be at least 8 characters long.";
	}

	if ($password !== $password2) {
		$errors[] = "Passwords do not match.";
	}

	// If there are no errors, proceed with registration
	if (empty($errors)) {
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		// TODO: Insert the user data into your database
		// For example, you could use PDO or mysqli to perform the database query
		// Here's some sample code using PDO:
		// $db = new PDO("mysql:host=localhost;dbname=mydatabase", "myusername", "mypassword");
		// $stmt = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
		// $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT)]);

		// Redirect the user to the landing page
		header("Location: landing.php");
		exit();
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Registration Page</title>
</head>
<body>
	<h1>Register for Ubay</h1>

	<?php if (!empty($errors)): ?>
		<div style="color: red;">
			<?php foreach ($errors as $error): ?>
				<p><?php echo $error ?></p>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<label for="username">Username:</label>
		<input type="text" name="username" id="username" value=" <?=(isset($username))?$username:""?>" required><br><br>

		<label for="email">Email:</label>
		<input type="email" name="email" id="email" value=" <?=(isset($email))?$email:""?>" required><br><br>

		<label for="password">Password:</label>
		<input type="password" name="password" id="password" required><br><br>

		<label for="password2">Verify Password:</label>
		<input type="password" name="password2" id="password2" required><br><br>

		<input type="submit" value="Sign Up">
	</form>
</body>
</html>
