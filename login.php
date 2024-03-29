<?php
require_once 'database_APIs/apiFunctions.php';
session_start();
// Check if the form has been submitted
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Retrieve the username and password from the form data
	$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$error_msg = login($username , $password);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Log In - Ubay</title>
	<link rel="stylesheet" type="text/css" href="CSS/style.css">
</head>
<body class="login-register-body">
<div class="login-register-page">
	<a href="#" class="login-register-close-button" id="login-close-button" onclick="history.back(); return false;">X</a>
	<div class="login-register-container">
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

		<input type="submit" value="Log In" class="blue-button-medium">
	</form>
	<p>New User? <a href="register.php">Click here</a> to register</p>

	</div>
</div>
</body>
</html>
