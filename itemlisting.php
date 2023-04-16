<!DOCTYPE html>
<html>
<head>
	<title>Item Listing Page</title>
	<link rel="stylesheet" href="CSS/itemlisting.css">
</head>
<body>
    <header>
		<?php require 'header.php'; ?>
	</header>

	<?php
	require_once 'database_APIs/apiFunctions.php';
	if(isset($_GET['keywords'])){
		$keywords = filter_var($_GET['keywords'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$errors = [];

		if(!empty($keywords)){
			// fetch all items related to keyword
			$result = searchItems($keywords);
			if ($result == -1) {
				echo "Error: Executing the procedure fialed ";
				exit;
			}
			$image_location = ($_SERVER['SERVER_NAME'] == 'localhost') ? '/images/' : '/CSE442-542/2023-Spring/cse-442j/images/';
			echo '<h1 style="color: #006ED3;">' . $keywords . '</h1>';
			echo '<div class="item-container">';
			while ($attr = $result->fetch_assoc()) {
				$image_path = $image_location . $attr['image'];
				$product_path = 'product_detail.php?productID=' . $attr['id'];
				echo '<div class="item">';
				echo '<a href="' . $product_path . '"><img src="' . $image_path . '" alt="item"></a>';
				echo '<h3>' . $attr['product_name'] . '</h3>';
				echo '<h3">$ ' . $attr['unit_price'] . '</h3>';
				echo '</div>';
			}
			echo '</div>';
			
		}else{
			// if input is empty, fetch all items on sale
			$result = getAllItems();
			if ($result == -1) {
				echo "Error: Executing the procedure fialed ";
				exit;
			}
			$image_location = ($_SERVER['SERVER_NAME'] == 'localhost') ? '/images/' : '/CSE442-542/2023-Spring/cse-442j/images/';
			echo '<h1 style="color: #006ED3;">All Items</h1>';
			echo '<div class="item-container">';
			while ($attr = $result->fetch_assoc()) {
				$image_path = $image_location . $attr['image'];
				$product_path = 'product_detail.php?productID=' . $attr['id'];
				echo '<div class="item">';
				echo '<a href="' . $product_path . '"><img src="' . $image_path . '" alt="item"></a>';
				echo '<h3>' . $attr['product_name'] . '</h3>';
				echo '<h3">$ ' . $attr['unit_price'] . '</h3>';
				echo '</div>';
			}
			echo '</div>';
		}
	}
	
?>

</body>
</html>