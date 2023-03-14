<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$address = filter_var($_POST["address"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$name = filter_var($_POST["name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$phone = filter_var($_POST["phone"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$city = filter_var($_POST["city"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$state = filter_var($_POST["state"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$zipcode = filter_var($_POST["zipcode"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$cardnumber = filter_var($_POST["cardnumber"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$cardname = filter_var($_POST["cardname"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$expiration = filter_var($_POST["expiration"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$errors = [];

	// Check if input is empty
    if (empty($address)) {$errors[] = "Address is required.";}

	if (empty($name)) {$errors[] = "Full Name is required.";}
	// Check if name contains only letters
	elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {$errors[] = "Full Name can only contain letters";}

	if (empty($phone)) {$errors[] = "Phone Number is required.";}
	// Check if phone number contains only numbers and is of length 10
	elseif (!preg_match("/^[0-9]{10}$/", $phone)) {$errors[] = "Phone Number can only contain numbers and must be 10 digits";}

	if (empty($city)) {$errors[] = "City is required.";}
	// Check if city contains only letters
	elseif (!preg_match("/^[a-zA-Z ]*$/", $city)) {$errors[] = "City can only contain letters";}
	
	if (empty($state)) {$errors[] = "State is required.";}
	// Check if state contains only letters
	elseif (!preg_match("/^[a-zA-Z ]*$/", $state)) {$errors[] = "State can only contain letters";}

	if (empty($zipcode)) {$errors[] = "Zip Code is required.";}
	// Check if zip code contains only numbers and is of length 5
	elseif (!preg_match("/^[0-9]{5}$/", $zipcode)) {$errors[] = "Zip Code can only contain numbers and must be 5 digits";}

	if (empty($cardnumber)) {$errors[] = "Card Number is required.";}
	// Check if card number contains only numbers and is of length 16
	elseif (!preg_match("/^[0-9]{16}$/", $cardnumber)) {$errors[] = "Card Number can only contain numbers and must be 16 digits";}

	if (empty($cardname)) {$errors[] = "Name on Card is required.";}
	// Check if card name contains only letters
	elseif (!preg_match("/^[a-zA-Z ]*$/", $cardname)) {$errors[] = "Name on Card can only contain letters";}

	if (empty($expiration)) {$errors[] = "Expiration Date is required.";}
	// Check if expiration date is in format "yyyy/mm"
	elseif (!preg_match("/^(19|20)\d{2}\/(0[1-9]|1[0-2])$/", $expiration)) {$errors[] = "Expiration Date must be in format 'yyyy/mm'";}

}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Payment Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<header>
		<?php require 'header.php'; ?>
	</header>
	<main>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<section id="left">
				<h2>Shipping Address</h2>
				<p><label for="address">Address:</label><input type="text" id="address" name="address"></p>
				<p><label for="name">Full Name:</label><input type="text" id="name" name="name"></p>
				<p><label for="phone">Phone Number:</label><input type="text" id="phone" name="phone"></p>
				<p><label for="city">City:</label><input type="text" id="city" name="city"></p>
				<p><label for="state">State:</label><input type="text" id="state" name="state"></p>
				<p><label for="zipcode">Zip Code:</label><input type="text" id="zipcode" name="zipcode"></p>

				<h2>Payment Information</h2>
				<p><label for="cardnumber">Card Number:</label><input type="text" id="cardnumber" name="cardnumber"></p>
				<p><label for="cardname">Name on Card:</label><input type="text" id="cardname" name="cardname"></p>
				<p><label for="expiration">Expiration Date:</label><input type="text" id="expiration" name="expiration"></p>
				<button type="submit" id="confirm">Confirm Order</button>
			</section>
		</form>

		<section id="center">
			<?php if (!empty($errors)): ?>
				<div style="color: red;">
					<?php foreach ($errors as $error): ?>
						<p><?php echo $error ?></p>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</section>

		<section id="right">
			<h2>Order Summary</h2>
			<p>Items: $0.0</p>
	        <p>Shipping: $0.0</p>
	        <p>Total before tax: $0.0</p>
	        <p>Tax: $0.0</p>
	        <h3>Order Total: $0.0</h3>
		</section>

		
	</main>
</body>
</html>