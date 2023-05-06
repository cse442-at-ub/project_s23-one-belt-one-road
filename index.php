<!DOCTYPE html>
<html>
<head>
	<title>Ubay</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="CSS/style.css">
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
					require_once 'database_APIs/apiFunctions.php';
					$result = getNItems(4);
					if ($result == -1) {
						echo "<p>Error: Failed to get 4 products data from API</p>";
	    				exit;
					}
					$image_location = ($_SERVER['SERVER_NAME'] == 'localhost') ? '/images/' : '/CSE442-542/2023-Spring/cse-442j/';
					echo '<ul class="landing-item-list">';
					while ($row = $result->fetch_assoc()) {
						$image_path = $image_location . $row['image'];
						$product_path = 'product_detail.php?productID=' . $row['id'];
						echo '<li class="item-block-tall">';
						echo '<a href="' . $product_path . '"><img src="' . $image_path . '" alt="item" class="item-image-button"></br>' . $row['product_name'] . '</a>';
						echo '<span class="landing-item-title">$ ' . $row['unit_price'] . '</span>';
						echo '</li>';
					}
					echo '</ul>';
				?>
			</div>
			<p style="margin-top: 40px;">Get access to exclusive products from students.</p>
			<a href="<?php echo ($_SERVER['SERVER_NAME'] == 'localhost') ? '/itemlisting.php?keywords=' : '/CSE442-542/2023-Spring/cse-442j/itemlisting.php?keywords=' ?>" class="text-button" style="text-align: right;">See All</a>
		</section>
	</main>
	<?php require 'footer.php'; ?>
</body>
</html>
