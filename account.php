<?php
session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'oops, no username returned';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'oops, no email returned';
?>

<!DOCTYPE html>
<html>
<head>
	<title>My Account</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="CSS/style.css">
</head>
<body>
	<header>
		<?php require 'header.php'; ?>
	</header>
	<main>
		<section id="account-container" style="text-align: center; ">

			<h1 style="font-style: italic; margin-bottom: 50px;">Hi, <span><?php echo $username; ?></span>!</h1>

				<div class="flex-container">
					<div class="account-info">
						<h2 style="text-decoration: underline;">My Infomation</h2>
						<div class="account-info-list">
							<div class="info-block">
								<p class="info-title">username</p>
								<span id="username" class="info-content"><?php echo $username; ?></span>
							</div>
							<div class="info-block">
								<p class="info-title">email</p>
								<span id="email" class="info-content"><?php echo $email; ?></span>
							</div>
						</div>
					</div>

					<div class="account-blocks">

						<div class="mode-block" style="margin-bottom: 50px;">
							<h2>For Buyer</h2>
							<a href="purchase_orders.php"><button class="blue-button-large">Purchase Orders</button></a>
						</div>

						<div class="mode-block" style="margin-top: 50px;">
							<h2>For Seller</h2>
							<a href="sale_orders.php"><button class="blue-button-large">Sale Orders</button></a>
							<a href="my-listed-items.php"><button class="blue-button-large">Listed Items</button></a>
						</div>
					</div>
				</div>
			
		</section>
	</main>
	<?php require 'footer.php'; ?>
</body>
</html>