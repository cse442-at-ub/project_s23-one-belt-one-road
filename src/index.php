<!DOCTYPE html>
<html>
<head>
	<title>Ubay</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<header>
		<?php require 'header.php'; ?>
	</header>
	<main>
		<section id="trending-products" style="text-align: center;">
			<h1 style="font-style: italic; margin-bottom: 50px;">Trending</h1>
			<div style="text-align: center;">
				<?php
					// Connect to database and retrieve featured products
					// Loop through products and generate HTML code
				?>
				<ul style="list-style: none; display: flex; gap: 50px; justify-content: center;">
					<li style="display: flex; flex-direction: column; align-items: center;">
						<a href="#"><img src="#" alt="item" class="image-button" width="300"></br>Item Name</a>
						<h2>$ XX</h2>
					</li>
					<li style="display: flex; flex-direction: column; align-items: center;">
						<a href="#"><img src="#" alt="item" class="image-button" width="300"></br>Item Name</a>
						<h2>$ XX</h2>
					</li>
					<li style="display: flex; flex-direction: column; align-items: center;">
						<a href="#"><img src="#" alt="item" class="image-button" width="300"></br>Item Name</a>
						<h2>$ XX</h2>
					</li>
					<li style="display: flex; flex-direction: column; align-items: center;">
						<a href="#"><img src="#" alt="item" class="image-button" width="300"></br>Item Name</a>
						<h2>$ XX</h2>
					</li>
				</ul>
			</div>
			<p>Get access to exclusive products from students.</p>
			<a href="#" class="text-button" style="text-align: right;">See All</a>
		</section>
	</main>
	<footer style="text-align: center;">
		<p>&copy; 2023 Ubay Website.</p>
	</footer>
</body>
</html>
