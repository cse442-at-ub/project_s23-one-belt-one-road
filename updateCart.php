<?php
    require_once 'database_APIs/apiFunctions.php';
    $response = array();

    if (isset($_GET['userID']) && isset($_GET['productID']) && isset($_GET['amountChange'])) {
        $userID = $_GET['userID'];
        $productID = $_GET['productID'];
        $amountChange = $_GET['amountChange'];

        $result = addToShoppingCart($userID, $productID, $amountChange);
        
        if ($result == -1) {
            $response['success'] = false;
            $response['message'] = "Failed to update the item amount from cart.";
        } else {
            $response['success'] = true;
            $response['message'] = "Item amount updated from cart successfully.";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Error in XML HTTP Request.";
    }

    // Add debugging information to the response
    $response['debug'] = array(
        'userID' => $userID,
        'productID' => $productID,
        'amountChange' => $amountChange,
        'result' => $result
    );
    
    // Send a JSON-encoded response
    header('Content-Type: application/json');
    echo json_encode($response);
?>