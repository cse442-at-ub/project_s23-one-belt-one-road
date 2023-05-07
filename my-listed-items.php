<?php
session_start();
if (!isset($_SESSION['username'])) {
	header('Location: login.php');
  }
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
			<h1 style="font-style: italic; margin-bottom: 30px;">My Listed Items</h1>
			<div id="cartItems" class="item-blocks-long">
				<?php
					require_once 'database_APIs/apiFunctions.php';
					$listed_result = getListedItems($user_id);
					if ($listed_result == -1) {
						echo "<p>Error: Failed to get listed items from API</p>";
	    				exit;
					}
					$image_location = ($_SERVER['SERVER_NAME'] == 'localhost') ? '/' : '/CSE442-542/2023-Spring/cse-442j/';
					
					if ($listed_result->num_rows == 0) {
				        echo '<p style="margin-block: 100px;">No listed item. Start listing your item now!</p>';
				    } else {
						while ($listed_row = $listed_result->fetch_assoc()) {
							$image_path = $image_location . $listed_row['image'];
							$product_path = 'product_detail.php?productID=' . $listed_row['id'];
							echo '<div id="cartItem" class="item-block-long">';

								echo '<div class="item-block-long-info">';
									echo '<a href="' . $product_path . '" class="centered-link"><img src="' . $image_path . '" alt="item" class="item-block-long-image">' . $listed_row['product_name'] . '</a>';
									echo '<span class="item-price" type="number">$ ' . $listed_row['unit_price'] . '</span>';
								echo '</div>';

								echo '<span class="item-price" type="number">Inventory:  ' . $listed_row['inventory'] . '</span>';
							echo '</div>';
						}
					}
				?>
				
				<!-- <script>
				// Update an item inventory
				function updateInventory(userID, productID, amountChange) {
					return new Promise(function(resolve, reject) {
						console.log("Passing parameters to XML", userID, productID, amountChange);
						var xhr = new XMLHttpRequest();
						xhr.onreadystatechange = function() {
							if (this.readyState == 4) {
								if (this.status == 200) {
									// Handle the response from the server
									var response = JSON.parse(this.responseText);
									console.log(response);
									if (response.success) {
										resolve(response.message);
									} else {
										reject(new Error(response.message));
									}
								}
								else {
									console.log(this.readyState, this.status);
									reject(new Error("Failed to update item amount from cart"));
								}
							}
						}
						xhr.open("GET", "updateCart.php?userID=" + userID + "&productID=" + productID + "&amountChange=" + amountChange, true);
						xhr.send();
					});
				}
				</script> -->
				
			</div>
		</section>
	</main>
	<script src="functions.js"></script>
	<?php require 'footer.php'; ?>
</body>
</html>