<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if(isset($_GET['keywords'])){
        $keywords = filter_var($_GET['keywords'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $errors = [];

        if(!empty($keywords)){
            if(preg_match("/('|\"|\\\\)/", $keywords)){
                $errors[] = "Invalid Input.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<html>
    <body>
        <div>

            <div style="float: right; display: flex; align-items: center; margin-top: -5px;">
            <?php
                session_start(); // Start the session
                if (isset($_SESSION['username'])) { // If user is logged in
                    echo '
                        <a href="logout.php" class="text-button" style="font-size: 18px;">Log Out</a>
                        <a href="account.php" class="text-button" style="font-size: 18px;">My Account</a>
                        <a href="cart.php">
                            <img src="images/cart.png" alt="Shopping Cart" class="image-button" width="30">
                        </a>';
                } else { // If user is not logged in
                    echo '<a href="login.php" class="text-button" style="font-size: 18px; margin-top: 6px;">Log In</a>';
                }
            ?>
            </div>

            <div style="float: left; padding-top: 10px;">
                <a href="index.php" class="logo-button">
                    ubay
                </a>
            </div>

            <div style="clear: both;"></div>

            <div style="text-align: center; margin-top: -25px;">
                <form action="itemlisting.php?keywords="'.$keywords.' method="get" class="search-bar">
                    <input type="text" name="keywords" style="width: 500px;">
                        <button type="submit" class="blue-button" style="height: 30px;">SEARCH</button>
                </form>
            </div>

            <?php if (!empty($errors)): ?>
                <div style="color: red; text-align: center;">
                    <?php foreach ($errors as $error): ?>
                        <p><?php echo $error ?></p>
                    <?php endforeach; ?>
                </div>
			<?php endif; ?>

        </div>
    </body>
</html>
