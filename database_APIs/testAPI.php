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

        echo 'Search product (m)';
        $items = searchItems('m');
        if($items == -1){
            echo 'Error in query';
        }
		elseif ($items == 0){
            echo "\nNo results found";
        }
        else{
            echo 'Zero Errors in query';
            foreach ($items as $item) {
                echo '<div>' . $item['product_name'] . ': ' . $item['unit_price'] . '</div>';
            }

        }
        echo "\nGetting cart for user ID = 1\n";
        $items = getUserCart(1);
        if ($items == -1){
            echo "Error during api call";
        }
        else {
            foreach ($items as $item) {
                echo '<div>' . $item['productName'] . '</div>';
            }
        }
        echo "\nClearing cart for user ID = 1\n";
        $items = clearUserCart(1);
        if ($items == -1){
            echo "Error during api call";
        }
        else {
                echo "Deleted cart for user 1";
            }
        
                echo "\nClearing cart for user ID = 1\n";
        echo " <div> Adding transaction from 3, to = 2, ammount = 8 , description = Desc , shipping = ship <div>";
        $res = addTransaction(3 , 2 , 2 , "Desc" , 'Ship');
        if ($res == -1){
            echo "Error during api call";
        }
        else {
                echo "Added transaction!";
            }
        echo "FINISHED TESTING";
	?>
</body>
</html>
