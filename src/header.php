<!DOCTYPE html>
<html>
    <body>
        <div>

            <div style="float: right; display: flex; align-items: center;">
                <a href="account.php" class="text-button" style="font-size: 18px; margin-top: -4px;">My Account</a>
                <a href="cart.php">
                    <img src="images/cart.png" alt="Shopping Cart" class="image-button" width="30">
                </a>
            </div>

            <div style="float: left;">
                <a href="index.php">
                    <img src="/images/logo.png" alt="Logo" class="logo-button" width="120">
                </a>
            </div>

            <div style="clear: both;"></div>

            <div style="text-align: center; margin-top: -25px;">
                <form action="search.php" method="get" class="search-bar">
                    <input type="text" name="keywords" style="width: 500px;">
                    <button type="submit" class="blue-button" style="height: 30px;">SEARCH</button>
                </form>
            </div>

        </div>
    </body>
</html>
