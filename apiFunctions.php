<?php
//NOTE: establish_connection and close_connection should only be used within other API functions. Do not directly call these functions to accsess the database
//This function will take no parameters
function establish_connection() {
    $username = 'cqstuhle';
    $password = '50440370';
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
//IMPORTANT: both parameters need to be sanatisied (to prevent injection attacks) prior to calling function. 
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

        //close connection prior to returning
        close_connection($conn);

        //Built-in function used to verify plain text password with hashed password
		if (password_verify($password, $hashed_password)) {
			$_SESSION['logged_in'] = true;
            //message will not be printed due to redirection to index.php
			// echo '<p style="color: green;">' . "Successful login!" . '</p>';
			header('Location: index.php');
		}
		else {
			 return $error_msg;
				}
		}
		else {
            return $error_msg;
		}
}

//This function takes the string username, email, password, and password2 input from the user after submitting register form
//IMPORTANT: ALL parameters need to be sanatisied (to prevent injection attacks) prior to calling function. 
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
