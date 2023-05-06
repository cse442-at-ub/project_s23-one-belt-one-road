<!DOCTYPE html>
<html>
<head>
	<title>Confirmation Page</title>
	<link rel="stylesheet" type="text/css" href="CSS/payment-confirm.css">
</head>
<body>
	<header>
		<?php require 'header.php'; ?>
	</header>
	<div style="text-align: center;">
			<h1>Thank you for your order!</h1>
			<h2>Shipping Address:</h2>
			<?php
				$shipping = $_SESSION["shipping"];
				$amount = $_SESSION["amount"]; 
				echo '<p><label style="white-space: nowrap;">' . $shipping . '</label></p>';
				echo '<h3>Total Amount: $' . $amount . '</h3>';
			?>
	</div>

		
</body>
</html>