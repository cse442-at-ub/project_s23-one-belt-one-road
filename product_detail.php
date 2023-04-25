<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Product Detail</title>
	<link rel="stylesheet" href="style.css">
	<script src="script.js"></script>
	<?php require('header.php'); ?>
</head>
<body>
	<div id="content">
		<?php
			require_once 'database_APIs/apiFunctions.php';
			if (!isset($_GET['productID']) || empty($_GET['productID'])) {
				echo "<p>No product ID specified.</p>";
				exit;
			}

			$productID = $_GET['productID'];
			$product = getProductByID($productID);

			if ($product == -1) {
				echo "<p>Error: Failed to get product data from API</p>";
				exit;
			}

			if (!$product) {
				echo "<p>Product with ID $productID not found.</p>";
				exit;
			}

			$image_location = ($_SERVER['SERVER_NAME'] == 'localhost') ? '/images/' : '/CSE442-542/2023-Spring/cse-442j/images/';
			$image_path = $image_location . $product['image'];
		?>
		<div class="product-image-block-tall">
			<img src="<?php echo $image_path ?>" alt="Product Image">
		</div>
		<div class="product-details">
			<h2><?php echo $product['product_name'] ?></h2>
			<table>
				<tr>
					<td>Description:</td>
					<td><?php echo $product['description'] ?></td>
				</tr>
				<tr>
					<td>Inventory:</td>
					<td><?php echo ($product['inventory'] > 0) ? 'In Stock' : 'Out of Stock' ?></td>
				</tr>
				<tr>
					<td>Seller:</td>
					<td>@<?php echo $product['owner_id'] ?></td>
				</tr>
				<tr>
					<!-- TODO: Add seller rating in database -->
					<td>Seller Rating:</td>
					<td>4.42/5</td>
				</tr>
				<tr id="price-row">
					<td>Price:</td>
					<td class="price">$<?php echo number_format($product['unit_price'], 2) ?></td>
				</tr>
			</table>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?productID=" . $productID; ?>">
                    <input type="submit" name="add_to_cart" value="Add to Cart">
            </form>
		</div>
	</div>
	<?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['add_to_cart'])) {
                $userID = $_SESSION['user_id']; // Ensure the user ID is set in the session when the user logs in
                $result = addToShoppingCart($userID, $productID, 1); // Assuming a default quantity of 1

                if ($result == 1) {
                    echo '<script>alert("Item added to cart successfully.")</script>';
                } else {
                    echo '<script>alert("Error: Failed to add item to cart.")</script>';
                }
            }
        }
    ?>
	<?php require('footer.php'); ?>
</body>
</html>