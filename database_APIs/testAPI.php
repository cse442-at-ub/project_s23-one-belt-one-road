<!DOCTYPE html>
<html>
<head>
	<title>Displaying All Items</title>
</head>
<body>
	<?php
		require_once 'apiFunctions.php';
        // $items = getAllItems();
        // echo 'All items items:';
        // if($items == -1){
        //     echo 'Error in query';
        // }
		// else{
        //     echo 'Zero Errors in query';
        //     foreach ($items as $item) {
        //         echo '<div>' . $item['product_name'] . ': ' . $item['unit_price'] . '</div>';
        //     }
        // }
        // echo 'Now getting landing page items (2 items):';
        // $items = getNItems(2);
        // if($items == -1){
        //     echo 'Error in query';
        // }
		// else{
        //     echo 'Zero Errors in query';
        //     foreach ($items as $item) {
        //         echo '<div>' . $item['product_name'] . ': ' . $item['unit_price'] . '</div>';
        //     }
        // }
        // echo 'Add to Shopping cart (check DB)';
        // $res = addToShoppingCart(1 , 3, 10);
        // if($res == -1){
        //     echo "Error in query";
        // }
        // else{
        //     echo "Updated Cart!";
        // }
        // //NOTE: Bug in DB procedure, does not update existing item, instead adds it again

        // echo 'Search product (m)';
        // $items = searchItems('m');
        // if($items == -1){
        //     echo 'Error in query';
        // }
		// elseif ($items == 0){
        //     echo "\nNo results found";
        // }
        // else{
        //     echo 'Zero Errors in query';
        //     foreach ($items as $item) {
        //         echo '<div>' . $item['product_name'] . ': ' . $item['unit_price'] . '</div>';
        //     }

        // }
        // echo "\nGetting cart for user ID = 1\n";
        // $items = getUserCart(1);
        // if ($items == -1){
        //     echo "Error during api call";
        // }
        // else {
        //     foreach ($items as $item) {
        //         echo '<div>' . $item['productName'] . '</div>';
        //     }
        // }
        // echo "\nClearing cart for user ID = 1\n";
        // $items = clearUserCart(1);
        // if ($items == -1){
        //     echo "Error during api call";
        // }
        // else {
        //         echo "Deleted cart for user 1";
        //     }
        
        //         echo "\nClearing cart for user ID = 1\n";
        // echo " <div> Adding transaction from 3, to = 2, ammount = 8 , description = [{'productID': 1, 'quantity': 2}] , shipping = ship <div>";
        // // $res = addTransaction(3 , 2 ,  '[{"productID": 1, "quantity": 2}]' , 'Ship test');
        // if ($res == -1){
        //     echo "Error during api call";
        // }
        // else {
        //         echo "Added transaction!";
        //     }
        // echo " <div> Retrieving transactions for user ID = 1 <div>";
        // $items = getTransactionBySellerID(1);
        // if ($items == -1){
        //     echo "Error during api call";
        // }
        // else {
        //     foreach ($items as $item) {
        //         echo "ID: " . $item['id'] . " Buyer ID: " . $item['buyerID'] . " Seller ID: " . $item['sellerID'] . " Amount: " . $item['amount'] . " Datetime: " . $item['datetime'] . " Order ID: " . $item['orderID'];

        //     }
        // }
        // $res = getOrderByUserID(36);
        // echo " <div> Getting order for buyerID = 36 <div>";
        // foreach ($res as $item) {
        //    echo "ID: " . $item['id'] . " Amount: " . $item['amount'];
        // }

        // $res = getOrderByOrderID(1);
        // echo " <div> Getting order for orderID = 1 <div>";
        // foreach ($res as $item) {
        //    echo "ID: " . $item['id'] . " Amount: " . $item['amount'];
        // }

        // $res = getListedItems(27);
        // echo " <div> Getting items listed by sellerID = 27 <div>";
        // foreach ($res as $item) {
        //    echo " ID: " . $item['id'] . " Product Name: " . $item['product_name'];
        // }

        // $orders = getAllOrders();
        // echo " <div> Getting all orders <div>";
        // foreach ($orders as $item) {
        //    echo "ID: " . $item['id'] . " Datetime: " . $item['datetime'];
        // }
	?>
</body>
</html>