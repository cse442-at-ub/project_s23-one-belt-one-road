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
				require_once 'database_APIs/apiFunctions.php';
				$shipping = $_SESSION["shipping"];
				echo '<p><label style="white-space: nowrap;">' . $shipping . '</label></p>';

				$userID = $_SESSION['user_id'];
				$cart_result = getUserCart($userID);
				$total_amount = 0;
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
				echo '<h3>Total Amount: $' . $total_amount . '</h3>';

				$result = addTransaction($userID, $total_amount, json_encode($description), $shipping);

				$clear = clearUserCart($userID);

			?>
			
			</div>

		
</body>
</html>