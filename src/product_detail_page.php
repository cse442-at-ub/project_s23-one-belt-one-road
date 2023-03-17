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
		<div class="product-image">
			<img src="product-image.jpg" alt="Product Image">
		</div>
		<div class="product-details">
			<h2>Product Details</h2>
			<table>
				<tr>
					<td>Condition:</td>
					<td>Used</td>
				</tr>
				<tr>
					<td>Status:</td>
					<td>In Stock</td>
				</tr>
				<tr>
					<td>Seller:</td>
					<td>@442guys</td>
				</tr>
				<tr>
					<td>Seller Rating:</td>
					<td>4.42/5</td>
				</tr>
				<tr>
					<td>Price:</td>
					<td class="price">$44,200</td>
				</tr>
			</table>
			<button id="add-to-cart">Add to Cart</button>
		</div>
	</div>
</body>
</html>
