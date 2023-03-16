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
		<section id="trending-products" style="text-align: center; ">
			<h1 style="font-style: italic; margin-bottom: 50px;">Trending</h1>
			<div style="text-align: center;">
				<?php
					// Connect to database and retrieve featured products
					// Loop through products and generate HTML code
				?>
				<ul class="landing-item-list">
					<li class="item-block-tall">
						<a href="#"><img src="/images/item-spam.png" alt="item" class="item-image-button"></br>SPAM 12 OZ</a>
						<span class="landing-item-title">$ 4.42<span>
					</li>
					<li class="item-block-tall">
						<a href="#"><img src="/images/item-mug.png" alt="item" class="item-image-button"></br>Handmade Mug</a>
						<span class="landing-item-title">$ 22.4<span>
					</li>
					<li class="item-block-tall">
						<a href="#"><img src="/images/item-bag.jpg" alt="item" class="item-image-button"></br>Amuseable Sun</a>
						<span class="landing-item-title">$ 44.2<span>
					</li>
					<li class="item-block-tall">
						<a href="#"><img src="/images/item-fries.jpg" alt="item" class="item-image-button"></br>Just Potatoes</a>
						<span class="landing-item-title">$ 2.24<span>
					</li>
				</ul>
			</div>
			<p style="margin-top: 40px;">Get access to exclusive products from students.</p>
			<a href="#" class="text-button" style="text-align: right;">See All</a>
		</section>
	</main>
	<?php require 'footer.php'; ?>
</body>
</html>
