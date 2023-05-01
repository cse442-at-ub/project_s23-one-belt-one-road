<?php
    require_once 'database_APIs/apiFunctions.php';
    $response = array();

    if (isset($_GET['userID']) && isset($_GET['productID'])) {
        $userID = $_GET['userID'];
        $productID = $_GET['productID'];

        $result = removeFromShoppingCart($userID, $productID);
        if ($result == -1) {
            $response['success'] = false;
            $response['message'] = "Failed to remove item from cart.";
        } else {
            $response['success'] = true;
            $response['message'] = "Item removed from cart successfully.";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Error in XML HTTP Request.";
    }

    // Send a JSON-encoded response
    header('Content-Type: application/json');
    echo json_encode($response);
?>