<?php
// Check if the form was submitted
require_once 'apiFunctions.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// Get the form input values
	$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
	$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$password2 = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	// Validate the input
	$errors = [];
	$hashed_password = password_hash($password, PASSWORD_DEFAULT);
	$conn = establish_connection();
	if (empty($username)) {
		$errors[] = "Username is required.";
	} elseif (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
		$errors[] = "Username must contain only alphanumeric characters";
	}
	$query = "SELECT username FROM user";
	$result = mysqli_query($conn, $query);
	while ($row = mysqli_fetch_assoc($result)) {
      if($row['username'] == $username){
		$errors[] = "Username already in use";
		break;
	  }
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

	if (empty($errors)) {
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		$sql = "INSERT INTO user (username, email, password)
		VALUES ('$username', '$email', '$hashed_password')";
		
		if ($conn->query($sql) === TRUE) {
		  $conn->close();
		//   echo "New account created successfully";
		  header("Location: login.php");

		} else {
		  echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Registration Page</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
</head>

<body class="login-register-body">
<div class="login-register-page">
	<a href="#" class="login-register-close-button" id="register-close-button" onclick="history.back(); return false;">X</a>
	<div class="login-register-container">

		<h1>Register for Ubay</h1>
		<?php if (!empty($errors)) : ?>
			<div style="color: red;">
				<?php foreach ($errors as $error) : ?>
					<p><?php echo $error ?></p>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<label for="username">Username:</label>
			<input type="text" name="username" id="username" value=" <?= (isset($username)) ? $username : "" ?>" required><br><br>

			<label for="email">Email:</label>
			<input type="email" name="email" id="email" value=" <?= (isset($email)) ? $email : "" ?>" required><br><br>

			<label for="password">Password:</label>
			<input type="password" name="password" id="password" required><br><br>

			<label for="password2">Verify Password:</label>
			<input type="password" name="password2" id="password2" required><br><br>

			<input type="submit" value="Sign Up" class="blue-button-medium">
		</form>
		<p>Already have an account? <a href="login.php">Click here</a> to sign in</p>
	</div>
</body>

</html>
