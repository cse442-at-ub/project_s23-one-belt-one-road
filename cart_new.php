<?php
session_start();
require 'apiFunctions.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ubay</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php require 'header.php'; ?>
    <main>
        <section id="cart" style="text-align: center;">
            <h1 style="font-style: italic; margin-bottom: 30px;">Shopping Cart</h1>
            <div id="cartItems" class="item-blocks-long">
                <?php
                    // Connect to database and retrieve user's shopping cart items
                    // Assumes that you have a function getCartItems($userID) in apiFunctions.php that returns the user's cart items
                    $userID = $_SESSION['user_id'];
                    $cartItems = getCartItems($userID);
                    if ($cartItems && mysqli_num_rows($cartItems) > 0) {
                        while ($row = mysqli_fetch_assoc($cartItems)) {
                            $productID = $row['product_id'];
                            $productName = $row['product_name'];
                            $productImageURL = $row['image_url'];
                            $productPrice = $row['price'];
                            $quantity = $row['quantity'];
                            $subtotal = $quantity * $productPrice;
                            // Generate HTML code for each cart item
                            echo "<div id=\"cartItem\" class=\"item-block-long\">
                                    <div class=\"item-block-long-info\">
                                        <a href=\"product_detail_page.php?id=$productID\" class=\"centered-link\"><img src=\"$productImageURL\" alt=\"item\" class=\"item-block-long-image\">$productName</a>
                                        <span class=\"item-price\" type=\"number\">$ $productPrice</span>
                                    </div>
                                    <input type=\"number\" class=\"item-amount\" value=\"$quantity\">
                                    <span class=\"item-subtotal\">Subtotal $ $subtotal</span>
                                    <button class=\"cart-remove-button\">REMOVE</button>
                                  </div>";
                        }
                    } else {
                        echo "<p>Your shopping cart is empty.</p>";
                    }
                ?>
            </div>
            <label class="item-price">Total: $<span id="total"></span></label>
            <a href="payment.php" class="blue-button" style="font-size: 20px; margin-left: 20px;">CHECKOUT</a>
        </section>
    </main>
    <script src="functions.js"></script>
    <?php require 'footer.php'; ?>
</body>
</html>
