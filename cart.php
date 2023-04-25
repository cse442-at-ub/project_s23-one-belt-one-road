<?php
session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : -1;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Ubay</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="CSS/style.css">
</head>
<body>
	<?php require 'header.php'; ?>
	<main>
		<section id="cart" style="text-align: center;">
			<h1 style="font-style: italic; margin-bottom: 30px;">Shopping Cart</h1>
			<div id="cartItems" class="item-blocks-long">
				<?php
					require_once 'database_APIs/apiFunctions.php';
					$cart_result = getUserCart($user_id);
					if ($cart_result == -1) {
						echo "<p>Error: Failed to get shopping data from API</p>";
	    				exit;
					}
					$image_location = ($_SERVER['SERVER_NAME'] == 'localhost') ? '/images/' : '/CSE442-542/2023-Spring/cse-442j/images/';
					
					while ($cart_row = $cart_result->fetch_assoc()) {

						// Print out all column name and value in the $cart_row for testing
					    // $fields = mysqli_fetch_fields($cart_result);
						// foreach ($fields as $field) {
						//     echo $field->name . ": " . $cart_row[$field->name] . "<br>";
						// }
			
						$image_path = $image_location . $cart_row['image'];
						$product_path = 'product_detail.php?productID=' . $cart_row['productID'];
						echo '<div id="cartItem" class="item-block-long">';

							echo '<div class="item-block-long-info">';
								echo '<a href="' . $product_path . '" class="centered-link"><img src="' . $image_path . '" alt="item" class="item-block-long-image">' . $cart_row['productName'] . '</a>';
								echo '<span class="item-price" type="number">$ ' . $cart_row['unitPrice'] . '</span>';
							echo '</div>';

							echo '<input type="number" class="item-amount" value="' . $cart_row['amount'] . '">';
							echo '<span class="item-subtotal">Subtotal $ '. $cart_row['amount'] * $cart_row['unitPrice'] . '</span>';
							echo '<button class="cart-remove-button">REMOVE</button>';
						echo '</div>';
					}
				?>

					<!-- Old Template
					<div id="cartItem" class="item-block-long">
						<div class="item-block-long-info">
							<a href="product_detail_page.php" class="centered-link"><img src="/images/item-bag.jpg" alt="item" class="item-block-long-image">Amuseable Sun</a>
					    	<span class="item-price" type="number">$ 44.2</span>
					  	</div>
					  	<input type="number" class="item-amount" value="1">
					  	<span class="item-subtotal">Subtotal $ 44.2</span>
					  	<button class="cart-remove-button">REMOVE</button>
					</div> -->

			</div>
			<label class="item-price">Total: $<span id="total"></span></label>
			<a href="payment.php" class="blue-button" style="font-size: 20px; margin-left: 20px;">CHECKOUT</a>
		</section>
	</main>
	<script src="functions.js"></script>
	<?php require 'footer.php'; ?>
</body>
</html>
