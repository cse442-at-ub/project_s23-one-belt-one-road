<!DOCTYPE html>
<html>
<head>
	<title>Item Listing Page</title>
	<link rel="stylesheet" href="itemlisting.css">
</head>
<body>
    <header>
		<?php require 'header.php'; ?>
	</header>
	<h1 style="color: #006ED3;">Item Listing Page</h1>

	<div class="item-container">
		<div class="item">
			<a href="product_detail.php">
				<img src="/images/hat1.jpg" alt="Hat 1">
			</a>
			<h3>Hat 1</h3>
			<span>$10.00</span>
		</div>

		<div class="item">
			<a href="product_detail.php">
				<img src="/images/hat1.jpg" alt="Hat 2">
			</a>
			<h3>Hat 2</h3>
			<span>$15.00</span>
		</div>

		<div class="item">
			<a href="product_detail.php">
				<img src="/images/hat1.jpg" alt="Hat 3">
			</a>
			<h3>Hat 3</h3>
			<span>$20.00</span>
		</div>
        
	</div>
</body>
</html>