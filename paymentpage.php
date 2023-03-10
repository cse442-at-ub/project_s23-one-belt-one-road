<!DOCTYPE html>
<html>
<head>
	<title>Payment Page</title>
	<link rel="stylesheet" type="text/css" href="style3.css">
</head>
<body>
	<header>
		<img src="ubay.png" alt="Ubay Logo" id="logo">
	</header>
	<main>
		<section id="left">
			<h2>Shipping Address</h2>
			<p><label for="address">Address:</label><input type="text" id="address"></p>
			<p><label for="name">Full Name:</label><input type="text" id="name"></p>
			<p><label for="phone">Phone Number:</label><input type="text" id="phone"></p>
			<p><label for="city">City:</label><input type="text" id="city"></p>
			<p><label for="state">State:</label><input type="text" id="state"></p>
			<p><label for="zipcode">Zip Code:</label><input type="text" id="zipcode"></p>

			<h2>Payment Information</h2>
			<p><label for="cardnumber">Card Number:</label><input type="text" id="cardnumber"></p>
			<p><label for="cardname">Name on Card:</label><input type="text" id="cardname"></p>
			<p><label for="expiration">Expiration Date:</label><input type="text" id="expiration"></p>
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
	<footer>
		<button id="confirm">Confirm Order</button>
	</footer>
</body>
</html>
