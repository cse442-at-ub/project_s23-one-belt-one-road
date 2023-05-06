<?php
require_once "database_APIs/apiFunctions.php";
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $sellerID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : -1;
  $itemName = filter_input(INPUT_POST, 'item-name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $itemPrice = filter_input(INPUT_POST, 'item-price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
  $itemDesc = filter_input(INPUT_POST, 'item-desc',  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $itemQuantity = filter_input(INPUT_POST, 'item-quantity', FILTER_SANITIZE_NUMBER_INT);
  $file = "uploads/" . filter_input(INPUT_POST, "file_key", FILTER_SANITIZE_ENCODED);
  $erros = [];
  if ($file == "uploads/Invalid"){
    $errors[] = "Error: You must upload an image";
  }
  elseif($sellerID == -1){
    $errors[] = "Error: You must log in";
  }
  else {
  $conn = establish_connection();
  $sql = "INSERT INTO product (product_name, owner_id, unit_price, inventory, description, image) 
        VALUES ('$itemName', '$sellerID', $itemPrice, $itemQuantity, '$itemDesc', '$file')";

    if ($conn->query($sql) === TRUE) {
      header("Location: my-listed-items.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Post item</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="CSS/style.css">
	<style>
.add-image {
  width: 300px;
  height: 300px;
  background-color: #eee;
  border: 2px dashed #ccc;
  float: left;
  margin-right: 20px;
  margin-top: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
}

.add-image span {
  font-size: 24px;
  color: #aaa;
}
.item-details-heading {
  font-family: "Trebuchet MS", Verdana, Arial;
  font-style: italic;
  font-size: 30px;
    text-align: center;
    margin-top: 25px;
  }

.add-image.hide span {
  opacity: 0;
}

.input-form {
  overflow: hidden;
}

.input-form form {
  width: calc(100% - 320px);
  float: left;
  margin-top: 50px;
  color: #007bff;
}

.input-form label {
  display: inline-table;
  margin-bottom: 5px;
  font-weight: 1000;
}

.input-form input[type="text"],
.input-form input[type="number"],
.input-form textarea {
  width: 100%;
  padding: 10px;
  margin-bottom: 10px;
  border: 3px solid #ccc;
  border-radius: 10px;
  font-size: 100%;
  
}


.input-form button[type="submit"] {
  background-color: #007bff;
  color: #fff;
  padding: 20px 40px;
  border: none;
  border-radius: 50px;
  cursor: pointer;
  font-size: 24px;
}

.input-form button[type="submit"]:hover {
  background-color: #0069d9;
}

</style>
</head>
<body>
	<header>
		<?php require 'header.php'; ?>
	</header>
	<main>
  <h2 class="item-details-heading">Enter item details:</h2>
    <div class="add-image" id="add-image">
			<span>Click to add image</span>
			<input type="file" id="file-upload" style="display: none;">
      <!-- <button type="submit">Upload</button> -->
		</div>
        <div class="input-form" id="input-form">

				<form method = "post" enctype="multipart/form-data" action="post_item.php">
                    <div class="input-container">
                    <label for="item-name-input">Item Name:</label>
                    <input type="text" id="item-name-input" name="item-name" required maxlength="35" minlength = "4">
                    </div>

                    <div class="input-container">
                    <label for="item-price-input">Price (Per Unit):</label>
                    <input type="number" id="item-price-input" name="item-price" min=".01" step="0.01" required max="10000000">
                    </div>

                    <div class="input-container">
                    <label for="item-desc-input">Description:</label>
                    <input type="text" id="item-desc-input" name="item-desc" required maxlength="2000" minlength = "10">
                    </div>

                    <div class="input-container">
                    <label for="item-quantity-input">Quantity:</label>
                    <input type="number" id="item-quantity-input" name="item-quantity" min="1" max="10000" required>
                    </div>

                    <input type="hidden" name="file_key" value="Invalid">

					          <button type="submit">Post</button>
				</form>
		</div>
	</main>
	<?php require 'footer.php'; ?>
	<script>
    var addImage = document.getElementById('add-image');
    var fileName = "";
    var fileInput = document.getElementsByName("file_key")[0];

    addImage.addEventListener('click', function() {
        document.getElementById('file-upload').click();
    });

    document.getElementById('file-upload').addEventListener('change', function() {
        var file = this.files[0];
        fileName = file.name;
        fileInput.value = fileName;

        var reader = new FileReader();
        reader.onload = function(event) {
            addImage.style.backgroundImage = "url('" + event.target.result + "')";
            addImage.style.backgroundRepeat = "no-repeat";
            addImage.style.backgroundSize = "cover";
            addImage.style.backgroundPosition = "center";
            addImage.classList.add('hide');
        };
        reader.readAsDataURL(file);
          var formData = new FormData();
          formData.append("file", file);
          var xhttp = new XMLHttpRequest();
          // Set POST method and ajax file path
          xhttp.open("POST", "ajaxfile.php", true);
          xhttp.send(formData);
        
    });
	</script>
</body>
</html> 


