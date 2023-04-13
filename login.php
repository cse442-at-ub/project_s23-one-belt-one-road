<?php
session_start();
require_once 'apiFunctions.php';
// Check if the form has been submitted
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Retrieve the username and password from the form data
	$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	if (empty($errors)) {
		$login_error = login($username, $password);
		echo $login_error;
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
