<?php
// Check if the form has been submitted
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Retrieve the username and password from the form data
	$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	if (empty($errors)) {
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		$serverName = "oceanus.cse.buffalo.edu:3306";
		$dbUser = "UBITNAME";
		$dbPass = "PERSON NUM";
		$dbName = "cse442_2023_spring_team_j_db";
		$conn = mysqli_connect($serverName , $dbUser, $dbPass, $dbName);
		if (!$conn) {
			die("Connection failed: " . mysqli_connect_error());
		}
		$query = "SELECT password FROM user WHERE username = '$username'";
		$result = mysqli_query($conn, $query);
		if (mysqli_num_rows($result) == 1) {
			$row = mysqli_fetch_assoc($result);
			$hashed_password = $row['password'];

			if (password_verify($password, $hashed_password)) {
				$_SESSION['logged_in'] = true;
				echo '<p style="color: green;">' . "Successful login!" . '</p>';
				// header('Location: landing.php');
			  }
			else{
			$error_msg = 'Invalid username or password. Please try again';
				}
		}
		else {
		$error_msg = 'Invalid username or password. Please try again';
		}
		$conn->close();
}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Log In - Ubay</title>
	<link rel="stylesheet" type="text/css" href="styleLogReg.css">
</head>
<body>
<div class="container">
	<h1>Log In</h1>

	<?php
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
	<p>New User? <a href="Register.php">Click here</a> to register</p>
</div>
</body>
</html>
