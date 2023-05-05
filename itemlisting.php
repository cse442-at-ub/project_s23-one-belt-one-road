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
    
    <div class="sort-container">
        <label for="sort-select">Sort by:</label>
        <select id="sort-select">
            <option value="price-asc">Price (Low to High)</option>
            <option value="price-desc">Price (High to Low)</option>
        </select>
        <button id="sort-btn">Sort</button>
    </div>

	<?php
	require_once 'database_APIs/apiFunctions.php';
	if(isset($_GET['keywords'])){
		$keywords = filter_var($_GET['keywords'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $sort = $_GET['sort'] ?? null;
		$errors = [];

		if(!empty($keywords)){
			// fetch all items related to keyword
			$result = searchItems($keywords, $sort);
			if ($result == -1) {
				echo "Error: Executing the procedure fialed ";
				exit;
			}
			$image_location = ($_SERVER['SERVER_NAME'] == 'localhost') ? '/' : '/CSE442-542/2023-Spring/cse-442j/';
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
			$result = getAllItems($sort);
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

    <script>
        const sortBtn = document.getElementById('sort-btn');
        sortBtn.addEventListener('click', () => {
            const sortSelect = document.getElementById('sort-select');
            const sortValue = sortSelect.value;
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('sort', sortValue);
            window.location.href = currentUrl.href;
        });
    </script>

</body>
</html>