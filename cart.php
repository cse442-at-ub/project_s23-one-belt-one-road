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

						// $product_id = intval($cart_row['productID']);
						$item_detail_result = getProductByID($cart_row['productID']);
						if ($item_detail_result == -1) {
							echo "<p>Error: Failed to get specific item data from API</p>";
		    				exit;
						} else if ($item_detail_result == 0){
							echo "<p>Error: No specific item data from database</p>";
		    				exit;
						}

						$image_path = $image_location . $item_detail_result['image'];
						$product_path = 'product_detail.php?productID=' . $cart_row['productID'];
						echo '<div id="cartItem" class="item-block-long">';

							echo '<div class="item-block-long-info">';
								echo '<a href="' . $product_path . '" class="centered-link"><img src="' . $image_path . '" alt="item" class="item-block-long-image">' . $item_detail_result['product_name'] . '</a>';
								echo '<span class="item-price" type="number">$ ' . $item_detail_result['unit_price'] . '</span>';
							echo '</div>';

							echo '<input type="number" class="item-amount" value="1">';
							echo '<span class="item-subtotal">Subtotal $ '. $item_detail_result['unit_price'] . '</span>';
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
