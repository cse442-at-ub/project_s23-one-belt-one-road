<?php
    require_once 'database_APIs/apiFunctions.php';
    // echo 'Running the transition of removing an item from shopping cart...<br>';
    $response = array();

    if (isset($_GET['userID']) && isset($_GET['productID']) && isset($_GET['amount'])) {
        $userID = $_GET['userID'];
        $productID = $_GET['productID'];
        $amount = $_GET['amount'];
        // echo 'Got a XML HTTP Request for removing an item...<br>';
        // echo 'userID: ' . $userID . '<br>';
        // echo 'productID: ' . $productID . '<br>';
        // echo 'amount: ' . $amount . '<br>';
        $result = removeFromShoppingCart($userID, $productID, $amount);
        // echo $result;
        if ($result == -1) {
            // echo "Error: Failed to remove item from cart.<br>";
            $response['success'] = false;
            $response['message'] = "Failed to remove item from cart.";
        } else {
            // echo "Item removed from cart successfully.<br>";
            $response['success'] = true;
            $response['message'] = "Item removed from cart successfully.";
        }
    } else {
        // echo 'Error in XML HTTP Request<br>';
        $response['success'] = false;
        $response['message'] = "Error in XML HTTP Request.";
    }

    // Send a JSON-encoded response
    header('Content-Type: application/json');
    echo json_encode($response);
?>