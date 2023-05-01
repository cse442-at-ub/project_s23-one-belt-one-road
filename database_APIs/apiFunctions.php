<?php

//To import a function from this file, you must include the line: "require_once 'apiFunctions.php'"; in your PHP code.
//Then you may use any function by calling it normally (i.e. establish_connection() will work properly)
//IMPORTANT: All parameters need to be sanatisied (to prevent injection attacks) prior to calling function.

//NOTE: establish_connection and close_connection should only be used if neccesarry. Otherwise, they will be called within other APIs
//This function will take no parameters
function establish_connection() {
    $username = 'fenghaih';
    $password = '50315030';
    $serverName = "oceanus.cse.buffalo.edu:3306";
    $dbName = "cse442_2023_spring_team_j_db";
    $conn = mysqli_connect($serverName, $username, $password, $dbName);
    if (!$conn) {
        //This will print the error message associated with the connection failure.
        die("Connection failed: " . mysqli_connect_error());
    }
    // Connection object will be used to execute prodecures and queries(i.e. $result = mysqli_query($conn, "SELECT * FROM ..."))
    return $conn;
}

//This function only accepts 1 parameter, which is a mysqli object. Otherwise a flag value will be returned
function close_connection($conn) {
    if (is_a($conn, "mysqli")) {
        #Close the connection
        $conn->close;
    } else {
        #Return value of -1 will indicate an unsuccsuessfull function call due to inccorecct parameter type
        return -1;
    }
}

//This function takes the string username and string password input from the user after submitting login form 
// Password must not be hashed when function is called 
// If login is succsuessfull, user will be relocated to index.php. Otherwise a string error message will be returned 
function login($username , $password) {
    //Establish database connection
    $conn = establish_connection();
    $error_msg = 'Invalid username or password. Please try again';
    //Query used to get hashed passwor if username exists in user table
    $query = "SELECT password FROM user WHERE username = '$username'";
	$result = mysqli_query($conn, $query);
	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_assoc($result);
        //Get hashed password from database if it exists
		$hashed_password = $row['password'];

        //Built-in function used to verify plain text password with hashed password
		if (password_verify($password, $hashed_password)) {
			$_SESSION['logged_in'] = true;
			$_SESSION['username'] = $username;
			$email_query = mysqli_query($conn, "SELECT email FROM user WHERE username = '$username'");
			$email_row = mysqli_fetch_assoc($email_query);
			$_SESSION['email'] = $email_row['email'];
            $id_query = mysqli_query($conn, "SELECT id FROM user WHERE username = '$username'");
            $id_row = mysqli_fetch_assoc($id_query);
            $_SESSION['user_id'] = $id_row['id'];
			echo '<p style="color: green;">' . "Successful login!" . '</p>';
            close_connection($conn);
			header('Location: account.php');
		}
		else {
            close_connection($conn);
			 return $error_msg;
		}
	}
	else {
        close_connection($conn);
        return $error_msg;
	}
}

//This function takes the string username, email, password, and password2 input from the user after submitting register form
// Password must not be hashed when function is called 
// If registartation is succsuessfull, user will be relocated to login.php. 
// Otherwise an array containing error messages will be returned (i.e. "Username is already in use"). Multiple error messages may be in array
function register($username, $email, $password , $password2){
	$errors = [];
	$hashed_password = password_hash($password, PASSWORD_DEFAULT);
	$conn = establish_connection();
	if (empty($username)) {
		$errors[] = "Username is required.";
	} elseif (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
		$errors[] = "Username must contain only alphanumeric characters";
	}
	$query = "SELECT username FROM user";
	$result = mysqli_query($conn, $query);
	while ($row = mysqli_fetch_assoc($result)) {
      if($row['username'] == $username){
		$errors[] = "Username already in use";
		break;
	  }
	}
	if (empty($email)) {

		$errors[] = "Email is required.";
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$errors[] = "Invalid email format.";
	}

	if (empty($password)) {
		$errors[] = "Password is required.";
	} elseif (strlen($password) < 8) {
		$errors[] = "Password must be at least 8 characters long.";
	}

	if ($password !== $password2) {
		$errors[] = "Passwords do not match.";
	}

	if (empty($errors)) {
		$sql = "INSERT INTO user (username, email, password)
		VALUES ('$username', '$email', '$hashed_password')";
		if ($conn->query($sql) === TRUE) {
            close_connection($conn);
		  header("Location: login.php");
		//   echo "New account created successfully";
		} 
		close_connection($conn);
		return $errors;
	}
}
//This function takes no parameters and will return all items in the the database
// return format (if succsuessful) will be a list of lists, with each list of the structure ['id' , 'product_name', 'owner_id', 'unit_price', 'inventory', 'description' , 'image' ]
// Otherwise, flag value of -1 will be returned -> indicating an error executing the procedure
function getAllItems(){
    $conn = establish_connection();
    // Call the stored procedure
    $query = "CALL getAllProduct()";
    $result = mysqli_query($conn, $query);
    close_connection($conn);
    if (!$result) {
        return -1;
    }
    return $result;

}

//This function takes an integer parameter for the number of items that will be returned.
// return format (if succsuessful) will be $productCount lists , with each list of the structure ['id' , 'product_name', 'owner_id', 'unit_price', 'inventory', 'description' , 'image' ]
// Otherwise, flag value of -1 will be returned -> indicating an error executing the procedure
function getNItems($productCount){
    $conn = establish_connection();
    // Call the stored procedure
    $stmt = $conn->prepare("CALL getLandingPageProduct(?)");
    $stmt->bind_param("i", $productCount);
    // Execute the statement
    $stmt->execute();
    // Get the result 
    $result = $stmt->get_result();
    close_connection($conn);
    $stmt->close();
    if (!$result) {
        return -1;
    }
    return $result;
}

//This function takes in parameters userID, productID. The entire quantity of the product will be removed from the cart
// -1 return value indicates an error executing the procedure. 1 indicates item was removed from cart.
//TODO: Edge cases (negative items), update to use amount (database procedure currently does not except an ammount parameter)
function removeFromShoppingCart($userID, $productID){
    $conn = establish_connection();
    $stmt = $conn->prepare("CALL removeFromShoppingCart(?, ?)");
    $stmt->bind_param("ii", $userID, $productID);
    // Execute the statement
    $stmt->execute();
    // Handle the result
    if ($stmt->errno) {
        $stmt->close();
        close_connection($conn);
        return -1;
    } else {
        $stmt->close();
        close_connection($conn);
        return 1;
    }
}

//This function takes in parameters userID, productID, and ammount (the ammount of productID that should be added to cart)
// -1 return value indicates an error executing the procedure. 1 indicates ammount items were added to cart
//TODO: Edge cases (amount greater than available for sale)
function addToShoppingCart($userID, $productID, $amount){
    $conn = establish_connection();
    $stmt = $conn->prepare("CALL addToShoppingCart(?, ?, ?)");
    $stmt->bind_param("iii", $userID, $productID, $amount);
    // Execute the statement
    $stmt->execute();
    // Handle the result
    if ($stmt->errno) {
        $stmt->close();
        close_connection($conn);
        return -1;
    } else {
        $stmt->close();
        close_connection($conn);
        return 1;
    }
}

//This function takes an string parameter, which is the search phrase input from the user
// return format (if succsuessful) will be N lists , with each list of the structure ['id' , 'product_name', 'owner_id', 'unit_price', 'inventory', 'description' , 'image' ]
// Otherwise, flag value of -1 will be returned -> indicating an error executing the procedure. Or flag value of 0 will be returned -> indicating no results were found in database
function searchItems($search){
    $conn = establish_connection();
    $stmt = $conn->prepare("SELECT * FROM product p WHERE p.product_name LIKE CONCAT('%',?,'%')");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    close_connection($conn);
    return $result;
    if (!$result) {
        return -1;
    }
    elseif(mysqli_num_rows($result) == 0){
        return 0;
    }
    return $result;
}

//This function takes in parameters userID, which is the ID of the user whos cart we will retrieve
// -1 return value indicates an error executing the procedure. 
// Otherwise a 2d array, witch each row of the format [productID , productName,	amount, image, unitPrice, description] will be returned
function getUserCart($userID){
    $conn = establish_connection();
    $stmt = $conn->prepare("CALL getShoppingCartByUserID(?)");
    $stmt->bind_param("i", $userID);
    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();
    // Handle the result
    if (!$result) {
        $stmt->close();
        close_connection($conn);
        return -1;
    } else {
        $stmt->close();
        close_connection($conn);
        return $result;
    }
}

//This function takes in parameters userID, which is the ID of the user whos cart we will retrieve
// -1 return value indicates an error executing the procedure. 1 indicates the cart was cleared
function clearUserCart($userID){
    $conn = establish_connection();
    $stmt = $conn->prepare("CALL clearShoppingCart(?)");
    $stmt->bind_param("i", $userID);
    // Execute the statement
    $stmt->execute();
    // Handle the result
    if ($stmt->errno) {
        $stmt->close();
        close_connection($conn);
        return -1;
    } else {
        $stmt->close();
        close_connection($conn);
        return 1;
    }
}

//This function takes in integer parameters $buyerID representing the buyer, and $amount which represents the dollar amount of the purchase
// This function takes in string parameters $description which represents the item description and $shipping which represents the shipping address of the buyer
// -1 return value indicates an error executing the procedure. 1 indicates the transaction was added
// Foe one product, description must follow JSON format: description = [{'productID': 1, 'quantity': 2}] 
// For multiple products, format is: [{"productID": 4, "quantity": 1}, {"productID": 5, "quantity": 3}]
function addTransaction($buyerID, $amount, $description, $shipping){
    $conn = establish_connection();
    $stmt = $conn->prepare("CALL add_order_transaction(?, ? , ? , ?)");
    $stmt->bind_param("iiss", $buyerID, $amount, $description, $shipping);
    // Execute the statement
    $stmt->execute();
    // Handle the result
    if ($stmt->errno) {
        $stmt->close();
        close_connection($conn);
        return -1;
    } else {
        $stmt->close();
        close_connection($conn);
        return 1;
    }
}

// New added function by Jiajun on 4/11
// This function takes the ID of the product you want to retrieve as a parameter
// Executes a SQL query to retrieve the product data from the database
// Returns the data as an associative array. 
// You can then use this function to retrieve the details of the product that the user clicked on and display them on the product detail page.
function getProductByID($productID) {
    $conn = establish_connection();
    $query = "SELECT * FROM product WHERE id=$productID";
    $result = mysqli_query($conn, $query);
    close_connection($conn);
    if (!$result) {
        return -1;
    } elseif(mysqli_num_rows($result) == 0){
        return 0;
    }
    return $result->fetch_assoc();
}

//This function takes an integer parameter that represented the seller ID
// return format (if succsuessful) will be N lists , with each list of the structure ['id' , 'buyerID' , 'sellerID' , 'amount' , 'datetime' , 'orderID' ]
// Otherwise, flag value of -1 will be returned -> indicating an error executing the procedure
function getTransactionBySellerID($userID) {
    $conn = establish_connection();
    $stmt = $conn->prepare("CALL getTransactionBySellerID(?)");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    close_connection($conn);
    $stmt->close();
    if (!$result) {
        return -1;
    }
    return $result;
}