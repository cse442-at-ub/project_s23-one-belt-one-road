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
		<section id="purchase_orders" style="text-align: center;">
			<h1 style="font-style: italic; margin-bottom: 30px;">Purchase Orders</h1>
			<div class="orders-container">
				<?php
					require_once 'database_APIs/apiFunctions.php';
					$orders_result = getOrderByUserID($user_id);
					if ($orders_result == -1) {
						echo "<p>Error: Failed to get orders data from API</p>";
	    				exit;
					}
					$image_location = ($_SERVER['SERVER_NAME'] == 'localhost') ? '/' : '/CSE442-542/2023-Spring/cse-442j/';
					
					if ($orders_result->num_rows == 0) {
				        echo '<p style="margin-block: 100px;">No past orders found. Buy something you like!</p>';
				    } else {
						while ($order_row = $orders_result->fetch_assoc()) {

							// Print out all column name and value in the $order_row for testing
						    // $fields = mysqli_fetch_fields($orders_result);
							// foreach ($fields as $field) {
							//     echo $field->name . ": " . $order_row[$field->name] . "<br>";
							// }
							// Print out variable types to confirm hashing work correctly
							// echo gettype($order_row['buyerID']);
							// echo gettype($order_row['datetime']);

							echo '<div class="order-block-container">';

								$order_number = hash('crc32', strval($order_row['buyerID']) . $order_row['datetime']);
								echo '<div class="order-top-container">';
									echo '<p class="order-top-info">Order #' . $order_number . '</p>';
									echo '<p class="order-top-info">' . $order_row['datetime'] . '</p>';
								echo '</div>';

								$order_description = json_decode($order_row['description']);
								foreach ($order_description as $item) {
								    $product_result = getProductByID($item->productID);
								    if ($product_result == -1) {
										echo "<p>Error: Failed to get products data from API</p>";
					    				exit;
									}

									// print the result of getting product detail
									// var_dump($product_result);

								    $image_path = $image_location . $product_result['image'];
									$product_path = 'product_detail.php?productID=' . $product_result['id'];

									echo '<div class="item-blocks-long">';
										echo '<div id="order-item-block" class="item-block-long">';
											echo '<div class="item-block-long-info">';
												echo '<a href="' . $product_path . '" class="centered-link"><img src="' . $image_path . '" alt="item" class="item-block-long-image">' . $product_result['product_name'] . '</a>';
												echo '<span class="item-price" type="number">$ ' . $product_result['unit_price'] . '</span>';
											echo '</div>';
											echo '<p class="order-item-quantity">Quantity: ' . $item->quantity . '</p>';
										echo '</div>';
									echo '</div>';
								}
								echo '<div class="order-bottom-container">';
									echo '<p id="order-bottom-shipping-address" class="order-bottom-info">' . $order_row['shipping'] . '</p>';
									echo '<p class="order-bottom-info">Total $' . $order_row['amount'] . '</p>';
								echo '</div>';

							echo '</div>';	
						}
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
		</section>
	</main>
	<?php require 'footer.php'; ?>
</body>
</html>
