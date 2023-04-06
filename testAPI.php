<!DOCTYPE html>
<html>
<head>
	<title>Displaying All Items</title>
</head>
<body>
	<?php
		require_once 'apiFunctions.php';
        $items = getAllItems();
        echo 'All items items:';
        if($items == -1){
            echo 'Error in query';
        }
		else{
            echo 'Zero Errors in query';
            foreach ($items as $item) {
                echo '<div>' . $item['product_name'] . ': ' . $item['unit_price'] . '</div>';
            }
        }
        echo 'Now getting landing page items (2 items):';
        $items = getNItems(2);
        if($items == -1){
            echo 'Error in query';
        }
		else{
            echo 'Zero Errors in query';
            foreach ($items as $item) {
                echo '<div>' . $item['product_name'] . ': ' . $item['unit_price'] . '</div>';
            }
        }
        echo 'Add to Shopping cart (check DB)';
        $res = addToShoppingCart(1 , 3, 10);
        if($res == -1){
            echo "Error in query";
        }
        else{
            echo "Updated Cart!";
        }
        //NOTE: Bug in DB procedure, does not update existing item, instead adds it again

        echo 'Search product (mug)';
        $items = searchItems('mug');
        if($items == -1){
            echo 'Error in query';
        }
		else{
            echo 'Zero Errors in query';
            foreach ($items as $item) {
                echo '<div>' . $item['product_name'] . ': ' . $item['unit_price'] . '</div>';
            }
        }
	?>
</body>
</html>
