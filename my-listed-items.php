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
			<h1 style="font-style: italic; margin-bottom: 30px;">My Listed Items</h1>
			<div id="cartItems" class="item-blocks-long">
				<?php
					require_once 'database_APIs/apiFunctions.php';

                    if (!isset($_GET['ownerID']) || empty($_GET['ownerID'])) {
                        echo "<p>No Seller ID specified.</p>";
                        exit;
                    }

                    $ownerID = $_GET['ownerID'];
			        $listed_result = getListedItemsBySellerID($ownerID);

					if ($listed_result == -1) {
						echo "<p>Error: Failed to get listed items data from API</p>";
	    				exit;
					}
					$image_location = ($_SERVER['SERVER_NAME'] == 'localhost') ? '/images/' : '/CSE442-542/2023-Spring/cse-442j/images/';
					
					if ($listed_result == 0) {
				        echo '<p style="margin-block: 100px;">No listed item. Start listing your product now!</p>';
				    } else {
						while ($listed_row = $listed_result->fetch_assoc()) {
							$image_path = $image_location . $listed_row['image'];
							$product_path = 'product_detail.php?productID=' . $listed_row['productID'];
							echo '<div id="cartItem" class="item-block-long">';

								echo '<div class="item-block-long-info">';
									echo '<a href="' . $product_path . '" class="centered-link"><img src="' . $image_path . '" alt="item" class="item-block-long-image">' . $cart_row['productName'] . '</a>';
									echo '<span class="item-price" type="number">$ ' . $listed_row['unitPrice'] . '</span>';
								echo '</div>';

								echo '<input id="cartItem-amount-' . $listed_row['productID'] . '" type="number" class="item-amount" value="' . $cart_row['amount'] . '">';
									echo '<script>
										document.getElementById("cartItem-amount-' . $listed_row['productID'] . '").addEventListener("change", function() {
											calculateTotal()
											.then(() => {
												var userID = "' . $user_id . '";
											    var productId = "' . $listed_row['productID'] . '";
											    var amountChange = this.value - ' . $listed_row['amount'] . ';
											    updateCart(userID, productId, amountChange)
											    .then(() => location.reload(true))
					        					.catch(error => console.error(error.message));
											});
										});
									</script>';
								echo '<span class="item-subtotal">Subtotal $ '. $listed_row['amount'] * $listed_row['unitPrice'] . '</span>';
								echo '<button class="cart-remove-button" data-product-id="' . $listed_row['productID'] . '">REMOVE</button>';
							echo '</div>';
						}
					}
				?>

				<script>

				// Update an item amount in shopping cart
				function updateCart(userID, productID, amountChange) {
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

				// Remove items from shopping cart
				function removeFromCart(userID, productID) {
				    // Send an AJAX request to the server-side PHP file
				    return new Promise(function(resolve, reject) {
					    var xmlhttp = new XMLHttpRequest();
					    xmlhttp.onreadystatechange = function() {
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
				                    reject(new Error("Failed to remove item from cart"));
				                }
					        } 
					    };
					    xmlhttp.open("GET", "removeFromCart.php?userID=" + userID + "&productID=" + productID, true);
					    xmlhttp.send();
					});
				}

				// Attach a click event listener to the "REMOVE" button
				var removeButtons = document.getElementsByClassName("cart-remove-button");
				for (var i = 0; i < removeButtons.length; i++) {
				    removeButtons[i].addEventListener("click", function() {
				        var userID = <?php echo $user_id; ?>;
				        var productID = this.getAttribute("data-product-id");
				        var amount = this.parentNode.querySelector(".item-amount").value;
				        removeFromCart(userID, productID, amount)
				        .then(() => location.reload(true))
				        .catch(error => console.error(error.message));
				    });
				}
				</script>
			</div>
			<label class="item-price">Total: $<span id="total"></span></label>
			<a href="payment.php" class="blue-button" style="font-size: 20px; margin-left: 20px;">CHECKOUT</a>
		</section>
	</main>
	<script src="functions.js"></script>
	<?php require 'footer.php'; ?>
</body>
</html>
