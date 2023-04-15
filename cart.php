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
					// Connect to database and retrieve featured products
					// Loop through products and generate HTML code
				?>
				
					<div id="cartItem" class="item-block-long">
					  	<div class="item-block-long-info">
					    	<a href="product_detail_page.php" class="centered-link"><img src="/images/item-spam.png" alt="item" class="item-block-long-image">SPAM 12Oz</a>
					    	<span class="item-price" type="number">$ 4.42</span>
					  	</div>
					  	<input type="number" class="item-amount" value="1">
					  	<span class="item-subtotal">Subtotal $ 4.42</span>
					  	<button class="cart-remove-button">REMOVE</button>
					</div>

					<div id="cartItem" class="item-block-long">
					  	<div class="item-block-long-info">
					    	<a href="product_detail_page.php" class="centered-link"><img src="/images/item-mug.png" alt="item" class="item-block-long-image">Handmade Mug</a>
					    	<span class="item-price" type="number">$ 22.4</span>
					  	</div>
					  	<input type="number" class="item-amount" value="1">
					  	<span class="item-subtotal">Subtotal $ 22.4</span>
					  	<button class="cart-remove-button">REMOVE</button>
					</div>

					<div id="cartItem" class="item-block-long">
						<div class="item-block-long-info">
							<a href="product_detail_page.php" class="centered-link"><img src="/images/item-bag.jpg" alt="item" class="item-block-long-image">Amuseable Sun</a>
					    	<span class="item-price" type="number">$ 44.2</span>
					  	</div>
					  	<input type="number" class="item-amount" value="1">
					  	<span class="item-subtotal">Subtotal $ 44.2</span>
					  	<button class="cart-remove-button">REMOVE</button>
					</div>

					<div id="cartItem" class="item-block-long">
						<div class="item-block-long-info">
							<a href="product_detail_page.php" class="centered-link"><img src="/images/item-fries.jpg" alt="item" class="item-block-long-image">Just Potatoes</a>
							<span class="item-price" type="number">$ 2.24</span>
						</div>
						<input type="number" class="item-amount" value="1">
						<span class="item-subtotal">Subtotal $ 2.24</span>
						<button class="cart-remove-button">REMOVE</button>
					</div>
			</div>
			<label class="item-price">Total: $<span id="total"></span></label>
			<a href="payment.php" class="blue-button" style="font-size: 20px; margin-left: 20px;">CHECKOUT</a>
		</section>
	</main>
	<script src="functions.js"></script>
	<?php require 'footer.php'; ?>
</body>
</html>
