<!DOCTYPE html>
<html>
<head>
	<title>Payment Page</title>
	<link rel="stylesheet" type="text/css" href="CSS/payment-confirm.css">
</head>
<body>
	<header>
		<?php require 'header.php'; ?>
	</header>
	<main>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<section id="left">
			

				<h2>Shipping Address</h2>
				
				<p>
					<label for="address">Address:</label>
					<input type="text" id="address" name="address" placeholder="Enter your address here">
					<?php if (!empty($address_error)): ?>
						<div style="color: red;">
							<?php foreach ($address_error as $error): ?>
								<p><?php echo $error ?></p>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</p>
				<p>
					<label for="name">Full Name:</label>
					<input type="text" id="name" name="name" placeholder="Enter your full name here">
					<?php if (!empty($name_error)): ?>
						<div style="color: red;">
							<?php foreach ($name_error as $error): ?>
								<p><?php echo $error ?></p>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</p>
				<p>
					<label for="phone">Phone Number:</label>
					<input type="text" id="phone" name="phone" placeholder="Enter 10 digits phone number here">
					<?php if (!empty($phone_error)): ?>
						<div style="color: red;">
							<?php foreach ($phone_error as $error): ?>
								<p><?php echo $error ?></p>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</p>
				<p>
					<label for="city">City:</label>
					<input type="text" id="city" name="city" placeholder="Enter your city here">
					<?php if (!empty($city_error)): ?>
						<div style="color: red;">
							<?php foreach ($city_error as $error): ?>
								<p><?php echo $error ?></p>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</p>
				<p>
					<label for="state">State:</label>
					<input type="text" id="state" name="state" placeholder="Enter your state here">
					<?php if (!empty($state_error)): ?>
						<div style="color: red;">
							<?php foreach ($state_error as $error): ?>
								<p><?php echo $error ?></p>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</p>
				<p>
					<label for="zipcode">Zip Code:</label>
					<input type="text" id="zipcode" name="zipcode" placeholder="Enter 5 digits zip code here">
					<?php if (!empty($zipcode_error)): ?>
						<div style="color: red;">
							<?php foreach ($zipcode_error as $error): ?>
								<p><?php echo $error ?></p>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</p>

				<h2>Payment Information</h2>
				<p>
					<label for="cardnumber">Card Number:</label>
					<input type="text" id="cardnumber" name="cardnumber" placeholder="Enter 16 digits card number here">
					<?php if (!empty($cardnumber_error)): ?>
						<div style="color: red;">
							<?php foreach ($cardnumber_error as $error): ?>
								<p><?php echo $error ?></p>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</p>
				<p>
					<label for="cardname">Name on Card:</label>
					<input type="text" id="cardname" name="cardname" placeholder="Enter the name on your card here">
					<?php if (!empty($cardname_error)): ?>
						<div style="color: red;">
							<?php foreach ($cardname_error as $error): ?>
								<p><?php echo $error ?></p>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</p>
				<p>
					<label for="expiration">Expiration Date:</label>
					<input type="text" id="expiration" name="expiration" placeholder="Enter expiration date (YYYY/MM)">
					<?php if (!empty($expiration_error)): ?>
						<div style="color: red;">
							<?php foreach ($expiration_error as $error): ?>
								<p><?php echo $error ?></p>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</p>
				
				<button type="submit" id="confirm">Confirm Order</button>
				
			</section>
		</form>

		<section id="center">
			
		</section>

		<section id="right">
			<h2>Order Summary</h2>
			<?php
				require_once 'database_APIs/apiFunctions.php';
				$userID = $_SESSION['user_id'];
				$cart_result = getUserCart($userID);
				$total_amount = 0;
		
				if ($cart_result == -1) {
					echo "<p>Error: Failed to get shopping data from API</p>";
					exit;
				} else {
					while ($row = mysqli_fetch_assoc($cart_result)) {
						$productName = $row['productName'];
						$amount = $row['amount'];
						$unitPrice = $row['unitPrice'];
						$total_cost = $amount * $unitPrice;
						$total_amount += $total_cost;
						echo '<p>' . $productName. '  *  '. $amount. ':   $'. $total_cost . '</p>';
					}
					echo '<h3>Order Total: $' . $total_amount . '</h3>';
				}
			?>
		</section>

		
	</main>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	require_once 'database_APIs/apiFunctions.php';

	$address = filter_var($_POST["address"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$name = filter_var($_POST["name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$phone = filter_var($_POST["phone"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$city = filter_var($_POST["city"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$state = filter_var($_POST["state"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$zipcode = filter_var($_POST["zipcode"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$cardnumber = filter_var($_POST["cardnumber"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$cardname = filter_var($_POST["cardname"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$expiration = filter_var($_POST["expiration"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$address_error = [];
	$name_error = [];
	$phone_error = [];
	$city_error = [];
	$state_error = [];
	$zipcode_error = [];
	$cardnumber_error = [];
	$cardname_error = [];
	$expiration_error = [];


	// Check if input is empty
    if (empty($address)) {$address_error[] = "Address is required.";}

	if (empty($name)) {$name_error[] = "Full Name is required.";}
	// Check if name contains only letters
	elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {$name_error[] = "Full Name can only contain letters.";}

	if (empty($phone)) {$phone_error[] = "Phone Number is required.";}
	// Check if phone number contains only numbers and is of length 10
	elseif (!preg_match("/^[0-9]{10}$/", $phone)) {$phone_error[] = "Phone Number can only contain numbers and must be 10 digits.";}

	if (empty($city)) {$city_error[] = "City is required.";}
	// Check if city contains only letters
	elseif (!preg_match("/^[a-zA-Z ]*$/", $city)) {$city_error[] = "City can only contain letters.";}
	
	if (empty($state)) {$state_error[] = "State is required.";}
	// Check if state contains only letters
	elseif (!preg_match("/^[a-zA-Z ]*$/", $state)) {$state_error[] = "State can only contain letters.";}

	if (empty($zipcode)) {$zipcode_error[] = "Zip Code is required.";}
	// Check if zip code contains only numbers and is of length 5
	elseif (!preg_match("/^[0-9]{5}$/", $zipcode)) {$zipcode_error[] = "Zip Code can only contain numbers and must be 5 digits.";}

	if (empty($cardnumber)) {$cardnumber_error[] = "Card Number is required.";}
	// Check if card number contains only numbers and is of length 16
	elseif (!preg_match("/^[0-9]{16}$/", $cardnumber)) {$cardnumber_error[] = "Card Number can only contain numbers and must be 16 digits.";}

	if (empty($cardname)) {$cardname_error[] = "Name on Card is required.";}
	// Check if card name contains only letters
	elseif (!preg_match("/^[a-zA-Z ]*$/", $cardname)) {$cardname_error[] = "Name on Card can only contain letters.";}

	if (empty($expiration)) {$expiration_error[] = "Expiration Date is required.";}
	// Check if expiration date is in format "yyyy/mm"
	elseif (!preg_match("/^(19|20)\d{2}\/(0[1-9]|1[0-2])$/", $expiration)) {$expiration_error[] = "Expiration Date must be in format 'YYYY/MM' and must be valid.";}

	if (empty($address_error) && empty($name_error) && empty($phone_error) &&
	empty($city_error) && empty($state_error) && empty($zipcode_error) &&
	empty($cardnumber_error) && empty($cardname_error) && empty($expiration_error)) { 

		
		$shipping = $address . ", " . $city . ", " . $state . " " . $zipcode;
		$_SESSION["shipping"] = $shipping; 
		$userID = $_SESSION['user_id'];
		$cart_result = getUserCart($userID);
		$total_amount = 0;
		$total_amount = floatval($total_amount);
		$description = array();

		if ($cart_result == -1) {
			echo "<p>Error: Failed to get shopping data from API</p>";
			exit;
		} else {
			while ($row = mysqli_fetch_assoc($cart_result)) {
				$productID = $row['productID'];
				$amount = $row['amount'];
				$unitPrice = $row['unitPrice'];
				$total_cost = $amount * $unitPrice;
				$total_amount += $total_cost;

				// Add product to the transaction description
				$description[] = array(
					"productID" => $productID,
					"quantity" => $amount
				);
			}
		}
		$_SESSION["amount"] = $total_amount; 
		$result = addTransaction($userID, $total_amount, json_encode($description), $shipping);
		$clear = clearUserCart($userID);

		header("Location: confirm.php"); 
		exit; }
					
}
?>