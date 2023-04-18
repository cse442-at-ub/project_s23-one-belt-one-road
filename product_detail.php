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
			require_once 'apiFunctions.php';
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
			<button id="add-to-cart-btn">Add to Cart</button>
		</div>
	</div>
	<?php require('footer.php'); ?>
</body>
<script>
    const addToCartBtn = document.getElementById('add-to-cart-btn');
    const priceRow = document.getElementById('price-row');
    const productId = '<?php echo $productID ?>';
    const productPrice = '<?php echo $product['unit_price'] ?>';

    addToCartBtn.addEventListener('click', () => {
        addToCart(productId, productPrice);
    });

    function addToCart(productId, productPrice) {
        const cartData = {
            product_id: productId,
            quantity: 1,
            unit_price: productPrice,
        };

        fetch('/api/cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(cartData),
        })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                alert('Product added to cart!');
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('Failed to add product to cart. Please try again later.');
            });
    }
</script>
</html>